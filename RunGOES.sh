#!/bin/bash

#tiffOutFolder='/home/olmozavala/Dropbox/MyProjects/UNAM/GOES/Animations/tiffs/'
#jpgOutFolder='/home/olmozavala/Dropbox/MyProjects/UNAM/GOES/Animations/images/'

tiffOutFolder='/media/osz1/DATA/Dropbox/MyProjects/UNAM/GOES/Animations/tiffs/'
jpgOutFolder='/media/osz1/DATA/Dropbox/MyProjects/UNAM/GOES/Animations/images/'
#fileType='mextiff'
fileType='tif_mexico'
python /media/osz1/DATA/Dropbox/MyProjects/UNAM/GOES/Animations/Main.py $tiffOutFolder $jpgOutFolder $fileType
