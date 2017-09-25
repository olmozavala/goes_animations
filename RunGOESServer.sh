#!/bin/bash

tiffOutFolder='/ServerData/GOES/tiffs/'
jpgOutFolder='/ServerData/GOES/images/'
python /ServerScripts/GOES/Main.py $tiffOutFolder $jpgOutFolder
