<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <?php
    // Array to hold all clusters of filenames
    $masterArray = array();

    // Sort all filenames into clustered arrays
    for ($x = 0; $x <= 23; $x++){
        $dir = dirname(__FILE__) . "/layer1/cluster" . $x+1;
        $filenames = scandir($dir);
        // remove current and parrent directories
        unset($filenames[0]);
        unset($filenames[1]);
        // reset keys
        $filenames = array_values($filenames);
        array_push($masterArray, $filenames);
    }
    
    //print_r($masterArray);
    
    ?>

    <body>
        <div class="main_container">
            <div class="topnav">
                <a>Deep Learner</a>
            </div>
            <div class="top_container">
                <div class="side_menu">
                    <div class="menu_header">
                        <a> Input image (original)</a>
                    </div>
                    <div>
                        <img src="images/mountain_lion.png" />
                    </div>
                
                    <div class="menu_header" id="selected_fmap">
                        <a> Selected feature map</a>
                    </div>
                    <div class="menu_img">
                        <img class="big_img" src="images/default_img.png" id="selected_img"/>
                        <img class="grid" src="images/lion_grid.png" />

                    </div>
                </div>
                
                <div class="mapbox_container">
                    <div class="mapbox_info_header">
                        <img src="Images/back.png" id="backButton" onclick="window.location.reload()">
                        <a id="mapbox_info"> Layer 1 Feature Maps (Showing 24/64) </a>
                    </div>
                    <div class="filler"></div>
                    <div class="map_box" id="mapbox">
                        <img src="layer1/featured_imgs/1.png" id="cluster1" onclick="renderCluster(1, 1)">
                        <img src="layer1/featured_imgs/2.png" id="cluster2" onclick="renderCluster(1, 2)"> 
                        <img src="layer1/featured_imgs/3.png" id="cluster3" onclick="renderCluster(1, 3)"> 
                        <img src="layer1/featured_imgs/4.png" id="cluster4" onclick="renderCluster(1, 4)"> 
                        <img src="layer1/featured_imgs/5.png" id="cluster5" onclick="renderCluster(1, 5)"> 
                        <img src="layer1/featured_imgs/6.png" id="cluster6" onclick="renderCluster(1, 6)"> 
                        <img src="layer1/featured_imgs/7.png" id="cluster7" onclick="renderCluster(1, 7)"> 
                        <img src="layer1/featured_imgs/8.png" id="cluster8" onclick="renderCluster(1, 8)"> 
                        <img src="layer1/featured_imgs/9.png" id="cluster9" onclick="renderCluster(1, 9)"> 
                        <img src="layer1/featured_imgs/10.png" id="cluster10" onclick="renderCluster(1, 10)"> 
                        <img src="layer1/featured_imgs/11.png" id="cluster11" onclick="renderCluster(1, 11)"> 
                        <img src="layer1/featured_imgs/12.png" id="cluster12" onclick="renderCluster(1, 12)"> 
                        <img src="layer1/featured_imgs/13.png" id="cluster13" onclick="renderCluster(1, 13)"> 
                        <img src="layer1/featured_imgs/14.png" id="cluster14" onclick="renderCluster(1, 14)"> 
                        <img src="layer1/featured_imgs/15.png" id="cluster15" onclick="renderCluster(1, 15)"> 
                        <img src="layer1/featured_imgs/16.png" id="cluster16" onclick="renderCluster(1, 16)"> 
                        <img src="layer1/featured_imgs/17.png" id="cluster17" onclick="renderCluster(1, 17)"> 
                        <img src="layer1/featured_imgs/18.png" id="cluster18" onclick="renderCluster(1, 18)"> 
                        <img src="layer1/featured_imgs/19.png" id="cluster19" onclick="renderCluster(1, 19)"> 
                        <img src="layer1/featured_imgs/20.png" id="cluster20" onclick="renderCluster(1, 20)"> 
                        <img src="layer1/featured_imgs/21.png" id="cluster21" onclick="renderCluster(1, 21)"> 
                        <img src="layer1/featured_imgs/22.png" id="cluster22" onclick="renderCluster(1, 22)"> 
                        <img src="layer1/featured_imgs/23.png" id="cluster23" onclick="renderCluster(1, 23)"> 
                        <img src="layer1/featured_imgs/24.png" id="cluster24" onclick="renderCluster(1, 24)">     
                    </div>
                    <div class="mapbox_controls">
                        <img src="Images/back.png" id="backButton" onclick="window.location.reload()">
                    </div>
                </div>
            </div>
            <div class="bottom_container">
                    <div class="menu_header" id="model_header">
                        VGG-16 Model
                    </div>
                    <div class="diagram_holder">
                        <img src="images/inputlayer.png">
                        <img src="images/arrow.png" class="arrow"/>
                        <img src="images/conv1-1.png">
                        <img src="images/conv1-2.png" onclick="window.location='index.php';" id="selectedlayer">
                        <img src="images/poolinglayer.png">
                        <img src="images/arrow.png" class="arrow"/>
                        <img src="images/conv2-1.png">
                        <img src="images/conv2-2.png" onclick="window.location='layer2.php';">
                        <img src="images/poolinglayer.png">
                        <img src="images/arrow.png" class="arrow"/>
                        <img src="images/conv3-1.png">
                        <img src="images/conv3-2.png">
                        <img src="images/conv3-3.png" onclick="window.location='layer3.php';">
                        <img src="images/poolinglayer.png">
                        <img src="images/arrow.png" class="arrow"/>
                        <img src="images/conv4-1.png">
                        <img src="images/conv4-2.png">
                        <img src="images/conv4-3.png" onclick="window.location='layer4.php';">
                        <img src="images/poolinglayer.png">
                        <img src="images/arrow.png" class="arrow"/>
                        <img src="images/conv5-1.png">
                        <img src="images/conv5-2.png">
                        <img src="images/conv5-3.png" onclick="window.location='layer5.php';">
                        <img src="images/poolinglayer.png">
                        <img src="images/arrow.png" class="arrow"/>
                        <img src="images/denselayer.png">
                        <img src="images/denselayer.png">
                        <img src="images/denselayer.png">
                        <img src="images/arrow.png" class="arrow"/>
                        <a>cougar (99.08%)</a>
                    </div>
            </div>
        </div>
        <script>
            
            function renderCluster(layer, cluster){
                //clear current images
                document.getElementById("mapbox").innerHTML = "";

                var passedArray = [];
                if (cluster == 1){
                    passedArray = <?php echo json_encode($masterArray[0]); ?>
                }
                else if(cluster == 2){
                    passedArray = <?php echo json_encode($masterArray[1]); ?>
                }
                else if(cluster == 3){
                    passedArray = <?php echo json_encode($masterArray[2]); ?>
                }
                else if(cluster == 4){
                    passedArray = <?php echo json_encode($masterArray[3]); ?>
                }
                else if(cluster == 5){
                    passedArray = <?php echo json_encode($masterArray[4]); ?>
                }
                else if(cluster == 6){
                    passedArray = <?php echo json_encode($masterArray[5]); ?>
                }
                else if(cluster == 7){
                    passedArray = <?php echo json_encode($masterArray[6]); ?>
                }
                else if(cluster == 8){
                    passedArray = <?php echo json_encode($masterArray[7]); ?>
                }
                else if(cluster == 9){
                    passedArray = <?php echo json_encode($masterArray[8]); ?>
                }
                else if(cluster == 10){
                    passedArray = <?php echo json_encode($masterArray[9]); ?>
                }
                else if(cluster == 11){
                    passedArray = <?php echo json_encode($masterArray[10]); ?>
                }
                else if(cluster == 12){
                    passedArray = <?php echo json_encode($masterArray[11]); ?>
                }
                else  if(cluster == 13){
                    passedArray = <?php echo json_encode($masterArray[12]); ?>
                }
                else if(cluster == 14){
                    passedArray = <?php echo json_encode($masterArray[13]); ?>
                }
                else if(cluster == 15){
                    passedArray = <?php echo json_encode($masterArray[14]); ?>
                }
                else if(cluster == 16){
                    passedArray = <?php echo json_encode($masterArray[15]); ?>
                }
                else if(cluster == 17){
                    passedArray = <?php echo json_encode($masterArray[16]); ?>
                }
                else if(cluster == 18){
                    passedArray = <?php echo json_encode($masterArray[17]); ?>
                }
                else if(cluster == 19){
                    passedArray = <?php echo json_encode($masterArray[18]); ?>
                }
                else if(cluster == 20){
                    passedArray = <?php echo json_encode($masterArray[19]); ?>
                }
                else if(cluster == 21){
                    passedArray = <?php echo json_encode($masterArray[20]); ?>
                }
                else if(cluster == 22){
                    passedArray = <?php echo json_encode($masterArray[21]); ?>
                }
                else if(cluster == 23){
                    passedArray = <?php echo json_encode($masterArray[22]); ?>
                }
                else if(cluster == 24){
                    passedArray = <?php echo json_encode($masterArray[23]); ?>
                }
                
                for(let i=0; i < passedArray.length; i++){
                    var path = "/layer" + layer + "/cluster" + cluster + "/" + passedArray[i];
                    var img = document.createElement('img');
                    img.src = path;
                    img.onclick = function() {
                        document.getElementById("selected_img").src = this.src;
                    }
                    document.getElementById("mapbox").appendChild(img);
                    document.getElementById("mapbox_info").innerHTML = "Layer 1 Feature Maps (Cluster " + cluster + ")";
                    document.getElementById("backButton").style.display = "block"
                }
            }
            
        </script>
    </body>
</html>