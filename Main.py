import pysftp
from pandas import DataFrame, Series
import pandas as pd
import sys, os
from datetime import datetime, date
from imagefromgoes import *

host = '132.247.103.143'
tiffOutFolder = 'output'
user= 'usuarioext'
passw = 'conf$39p'

# Bands to download
# 01 Blue
# 02 Red
# 03 Veggie
# 04 Cirrus
# 05 Snow/Ice
# 06 Cloud particle Size
# 07 Shortwave window
# 08 Upper-Level Tropospheric Water Vapor band
# 09 Mid-Level Tropospheric Water Vapor
# 10 Low-Level Tropospheric Water Vapor
# 11 Cloud-Top Phase
# 12 Ozone band
# 13 Clean Infrared
# 14 IR longwave
# 15 Dirty
# 16 CO2

# Define which type of files we want to download
fileTypes = {1:"geotiff", 2:"netcdf", 3:"mextiff", 4:"histmex"} 
fileType = "mextiff"
# Obtain only one band
bands = ['C13']

# This function MUST receive a date in the format 'YYYY-MM-DD' and a Time in the format 0-24
if __name__ == "__main__":

    args = sys.argv
    tiffOutFolder = args[1]
    jpgOutFolder = args[2]

    print("Folder to save tiff files:", tiffOutFolder)
    print("Folder to save jpg files:", jpgOutFolder)
    cnopts = pysftp.CnOpts()
    cnopts.hostkeys = None
    # Make the connection
    with pysftp.Connection(host,username=user,password=passw,cnopts=cnopts) as sftp:

        print("Reading data from ftp....")
        # Case for RGB geotiff
        if fileType == fileTypes.get(1):
            sftp.chdir('tif_mexico')
        elif fileType == fileTypes.get(2):
        # Case for tiff mex no RGB
            sftp.chdir('mexico_netcdf')
        elif fileType == fileTypes.get(3):
        # Case for netcdf
            sftp.chdir('tif_mexico')
        elif fileType == fileTypes.get(4):
        # Case for historic tif mex
            sftp.chdir('/nexus/proc/products/exportadas/geotiff/mexico')

        currFiles = sftp.listdir()
        files = Series(currFiles)
        #print(files)

        print("Downloading files...")
        # Case for geotiff
        if fileType == fileTypes.get(1):
            data = [[row] for row in files]
            dates = [datetime.strptime(row.split('-')[0],"%Y.%m%d.%H%M%S.goes") for row in files]

            df = DataFrame(data,columns=['file'],index=dates)
            df = df.tail(3)
            for dfile in df.loc[:]['file']:
                print('Downloading file: ', dfile)
                sftp.get(dfile,localpath=tiffOutFolder)

        elif fileType == fileTypes.get(2) or fileType == fileTypes.get(3) or fileType == fileTypes.get(4): 
        # Case for netcdf or mexico geotiff
            data = [[row.split('_')[2],row] for row in files]
            dates = [datetime.strptime(row.split('_')[1],"%Y.%m%d.%H%M%S.goes-16") for row in files]

            df = DataFrame(data,columns=['band','file'],index=dates)

            today = datetime.now()
            # For all the selected bands we download todays files
            for band in bands:
                # This can be used if we want to download all the files from one band
                #idx = df.loc[:]['band'].values == band

                # Select only the files for the last 30 minutes
                if  fileType == fileTypes.get(4): #historic
                    idx = df.loc[:]['band'].values == band
                    downFiles = df.loc[:]['file'][idx]
                else: # mextiff
                    # Read from last day
                    minDateTime = datetime(today.year,today.month,today.day,max(today.hour-1,0), max(today.minute,0))

                    idx = df.loc[minDateTime:]['band'].values == band
                    downFiles = df.loc[minDateTime:]['file'][idx]

                # Download all the layers for selected band
                downFiles
                for dfile in downFiles:
                    filepath = tiffOutFolder+dfile
                    if not(os.path.isfile(filepath)):
                        print('Downloading file: ', dfile)
                        sftp.get(dfile,localpath=filepath)

    
    # Create images from output to images
    print("Getting jpg images....")
    filesToProcess = os.listdir(tiffOutFolder)
    for fileName in filesToProcess:
        try:
            filepath = tiffOutFolder+fileName
            outFile = jpgOutFolder+fileName+'.jpg'
            if not(os.path.isfile(outFile)):
                print("Working with: ", filepath)
                makeJpg(filepath,1, jpgOutFolder)
        except Exception as e:
            print("ERROR: Not able to create jpg for:", fileName)
            print(e)
    #break; # This makes to read only one value
