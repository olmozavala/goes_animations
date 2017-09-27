#!/bin/bash

tiffOutFolder='/ServerData/GOES/tiffs/'
jpgOutFolder='/ServerData/GOES/images/'
/usr/local/anaconda/bin/python /ServerScripts/GOES/Main.py $tiffOutFolder $jpgOutFolder
