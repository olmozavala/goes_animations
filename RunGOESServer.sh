#!/bin/bash

tiffOutFolder='/ServerData/GOES/tiffs/'
jpgOutFolder='/ServerData/GOES/images/'
fileType='mextiff'
python /home/olmozavala/Dropbox/MyProjects/GOES/Animations/Main.py $tiffOutFolder $jpgOutFolder $fileType
/usr/local/anaconda/bin/python /ServerScripts/GOES/Main.py $tiffOutFolder $jpgOutFolder
