#!/bin/bash

tiffOutFolder='/ServerData/GOES/tiffs/'
jpgOutFolder='/ServerData/GOES/images/'
fileType='mextiff'
/usr/local/anaconda/bin/python /ServerScripts/GOES/Main.py $tiffOutFolder $jpgOutFolder $fileType
