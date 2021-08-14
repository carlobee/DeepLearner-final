# DeepLearner

An interactive convolutional neural network visualisation tool which implements clustered feature maps.

![Imgur Image](https://imgur.com/a/6nHdUpB)

## Installation

Create a virtual environment and install depedancies listed in `cnn/requirements.txt`.

## Execution

1. To generate new visualisations, place desired inout image in in `cnn/script.py`, modify `mountain_lion.jpg` to desired image.
2. Run `python3 script.py' to generate clsutered feature maps in current repository.
3. To view on front-end, copy layer directories to `\web` and create a new `\featured_imgs` directory in each `\layer`. Here you will paste 24 images, one from each cluster in the layer that you wish to be the representative feature map for each cluster. Name these `1` to `24`.
4. Start a local php server on localhost:80 to view visualisations.

Extra: uncomment dendrogram code in `main()` to view dendrogram results for each layer.

## Instructions

Navigate through layers using the model diagram to show 24 clusters of feature maps for each layer. Currently, only the final conv layer in each block is implemented. Click a cluster to see similar feature maps. Click on feature maps to enlarge next to original input image. 
