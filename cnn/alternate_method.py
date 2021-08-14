'''
Alternate program using KMeans clustering on a defined k value.

Written by Carl Bettosi
14/08/2021
'''



#------------------ LOAD LIBRARIES ------------------#
print('Loading libraries...')

# for everything else
import os
from threading import current_thread
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
import numpy as np
from numpy import expand_dims
from random import randint
import pandas as pd
import pickle

# for loading/processing/saving/displaying images 
from keras.applications.vgg16 import preprocess_input
from keras.preprocessing.image import load_img
from keras.preprocessing.image import img_to_array
from skimage.io import imsave
import matplotlib.pyplot as plt

# for the model
from keras.applications.vgg16 import VGG16
from keras.models import Model

# clustering and dimension reduction
from sklearn.cluster import KMeans
from sklearn.decomposition import PCA

class InputPass:

    def __init__(self, k):

        self.k = k # number of clusters
        self.all_fmaps = [] # all feature maps generated by model
        self.img_filenames = [] # all filenames of fmaps in order of model
        
        self.feature_set = {} # dictionary of img name:feature vector for all fmaps
        self.feature_names = [] # a list of the filenames
        self.features_only = [] # a list of only the feature vectors

        self.reduced_feature_set = [] # all feature vectors after dimentionality reduction via PCA
        self.cluster_groups = {} # dict of clustered feature maps group:[filename1,filename2]


    def process_input_img(self):
        print('Preparing image...')
        # load the image with the required shape
        img = load_img('bird.jpg', target_size=(224, 224))
        # convert the image to an array
        img = img_to_array(img)
        # expand dimensions so that it represents a single 'sample'
        img = expand_dims(img, axis=0)
        # prepare the image (e.g. scale pixel values for VGG16)
        img = preprocess_input(img)
        return img

    def redefine_VGG16_conv_blocks(self):
        model = VGG16()
        model.summary()
        # redefine model to output after each conv block
        ixs = [2, 5, 9, 13, 17]
        outputs = [model.layers[i].output for i in ixs]
        model = Model(inputs=model.inputs, outputs=outputs)
        return model

    def generate_feature_maps(self, model, img):
        self.all_fmaps = model.predict(img)

    def save_feature_maps(self):
        # define how many feature maps we want to save from each layer
        fmap_values = [64, 128, 256, 512, 512]

        # save feature map images to corresponding layer folders in file
        current_layer = 1
        featureCount = 0
        for layer in self.all_fmaps:
            for fmap in range(fmap_values[featureCount]):
                lname = 'layer'+ str(current_layer)
                fname = 'map' + str(fmap+1) + '.png'
                imsave(lname + '/' + lname+'_'+fname, layer[0, :, :, fmap])
                # create a list of all image filenames in format layerX_mapY
                self.img_filenames.append(lname+'_'+fname)
            current_layer+=1
            featureCount+=1


    def redefine_VGG16_fully_connected(self):
        # redefine the VGG16 model to remove the output layer
        model = VGG16()
        return Model(inputs=model.inputs, outputs=model.layers[-2].output)
        
    def get_feature_vector(self, file, model):
        img = load_img(file, target_size=(224,224))
        img = np.array(img)

        reshaped_img = img.reshape(1,224,224,3)
        final_img = preprocess_input(reshaped_img)

        # the final fully-connected layer is used as the a feature vector with 4096 numbers
        features = model.predict(final_img, use_multiprocessing=True)
        # retrun feature vector for single fmap
        return features

    def generate_feature_vector_set(self, model):
        os.chdir('layer1')
        for fmap in self.img_filenames:
            if 'layer1' not in fmap: # only do layer 1 feature maps for now
                pass
            else:
                vector = self.get_feature_vector(fmap, model)
                self.feature_set[fmap] = vector

        self.features_only = np.array(list(self.feature_set.values()))
        self.features_only = self.features_only.reshape(-1, 4096)
        self.filenames = np.array(list(self.feature_set.keys()))

    def reduce(self):
        pca = PCA(n_components=50, random_state=0)
        pca.fit(self.features_only)
        self.reduced_feature_set = pca.transform(self.features_only)

    def cluster(self):
        kmeans = KMeans(n_clusters=self.k, random_state=0)
        kmeans.fit(self.features_only)

        for file, cluster in zip(self.filenames, kmeans.labels_):
            if cluster not in self.cluster_groups.keys():
                self.cluster_groups[cluster] = []
                self.cluster_groups[cluster].append(file)
            else:
                self.cluster_groups[cluster].append(file)

        for x in range(0,4):
            print('Cluster ' + str(x))
            print('--------------------------------------------------------------------------')
            print(self.cluster_groups[x])
            print('')

    # function that lets you view a cluster (based on identifier)        
    def view_cluster(self, cluster):
        plt.figure(figsize = (40,40));
        # gets the list of filenames for a cluster
        files = self.cluster_groups[cluster]
        # only allow up to 30 images to be shown at a time
        if len(files) > 30:
            print(f"Clipping cluster size from {len(files)} to 30")
            files = files[:29]
        # plot each image in the cluster
        for index, file in enumerate(files):
            plt.subplot(10,10,index+1);
            img = load_img(file)
            img = np.array(img)
            plt.imshow(img)
            plt.axis('off') 
        plt.show()

    def calculate_K(self):
        sse = []
        list_k = list(range(3, 10))

        for k in list_k:
            km = KMeans(n_clusters=k, random_state=22)
            km.fit(self.reduced_feature_set)
            
            sse.append(km.inertia_)

        # Plot sse against k
        plt.figure(figsize=(6, 6))
        plt.plot(list_k, sse)
        plt.xlabel(r'Number of clusters *k*')
        plt.ylabel('Sum of squared distance');
        plt.show()

    def main(self):
        # generate the feature maps from the VGG16 model given the input image
        self.generate_feature_maps(self.redefine_VGG16_conv_blocks(), self.process_input_img())
        # save these maps to file and get filenames
        self.save_feature_maps()
        # Generate a dictinary with filename to feature vector mapping for each image
        self.generate_feature_vector_set(self.redefine_VGG16_fully_connected())
        # Use PCA to reduce dimentaionality
        self.reduce()
        # generate clusters of like-feature maps
        self.calculate_K()
        self.cluster()
        # view
        #self.view_cluster(0)
        #self.view_cluster(1)
        #self.view_cluster(2)
        #self.view_cluster(3)
        #self.view_cluster(4)
        
# Run program and predefine clusters
program = InputPass(5)
program.main()