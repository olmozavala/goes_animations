from pandas import DataFrame
from datetime import *
import matplotlib.pyplot as plt
import plotutils
import numpy as np
import os
from DataContainer import *

def makeAnimations(ftp, rootFolder, selectedDate, time, outputFolder):
    # Folder options:  boundary_layer_altitude_data
    folder = rootFolder+'/'+dataType+'/'+time+'/'
    # Create output folder
    outputFolder = outputFolder+'/'+selectedDate
    try:
        os.mkdir(outputFolder)
    except:
        print('warning: folder'+outputFolder+' already exists')

    files = ftp.nlst(folder)
    print(files)
    # Make 'generic' outputfile
    outFile = outputFolder+'/'

    # Iterate over all the files in the current FTP folder
    for currfile in files:

        temp = currfile.rfind('/')+1;
    
