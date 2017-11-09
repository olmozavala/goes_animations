import pysftp
from pandas import DataFrame, Series
import pandas as pd
import sys, os
from datetime import datetime, date, timedelta
from imagefromgoes import *

host = '132.248.26.119'
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
# Obtain only one band
bands = ['C13']

def downloadTiffImages(files, fileType, tiffOutFolder):
    print("Downloading files...")
    # Reads today's date, but in UTC format (that is how the server is setup)
    today = datetime.utcnow()
    # Read only from last hour
    minDateTime = today - timedelta(hours=1)

# ********************** Case for geotiff ************
    if fileType == fileTypes.get(1):
        data = [[row] for row in files]
        dates = [datetime.strptime(row.split('-')[0],"%Y.%m%d.%H%M%S.goes") for row in files]

        filesDataFrame = DataFrame(data,columns=['file'],index=dates)
        filesDataFrame = filesDataFrame.tail(3)
        for dfile in filesDataFrame.loc[:]['file']:
            print('Downloading file: ', dfile)
            sftp.get(dfile,localpath=tiffOutFolder)

    elif fileType == fileTypes.get(2) or fileType == fileTypes.get(3) or fileType == fileTypes.get(4): 
# ********************** All other cases ************
        # Puts in every row the band and the file name example: ['C13', 'Mexico_2017.....2km.tif']
        data = [[row.split('_')[2],row] for row in files] 
        # Gets the dates for all the files as an array of datetime
        dates = [datetime.strptime(row.split('_')[1],"%Y.%m%d.%H%M%S.goes-16") for row in files]
        # Creates a DataFrame with two columns, the band and the file name
        filesDataFrame = DataFrame(data,columns=['band','file'],index=dates)
        # For all the selected bands we download todays files
        for band in bands:
            # This can be used if we want to download all the files from one band
            #idx = filesDataFrame.loc[:]['band'].values == band

            # Select only the files for the last 30 minutes
# ********************** For histmex ************
            if  fileType == fileTypes.get(4): #historic
                idx = filesDataFrame.loc[:]['band'].values == band
                downFiles = filesDataFrame.loc[:]['file'][idx]
# ********************** For tif_mexico ************
            else: # mextiff
                idx = filesDataFrame.loc[minDateTime:]['band'].values == band
                downFiles = filesDataFrame.loc[minDateTime:]['file'][idx]

            # Download all the layers for selected band
            for dfile in downFiles:
                filepath = tiffOutFolder+dfile
                if not(os.path.isfile(filepath)):
                    print('Downloading file: ', dfile)
                    sftp.get(dfile,localpath=filepath)

        # Select which files to delete
        idx = filesDataFrame.loc[:minDateTime]['band'].values == band
        deleteFiles = filesDataFrame.loc[:minDateTime]['file'][idx]

    print('Deleting files....')
    for curFile in deleteFiles.values:
        filepath = tiffOutFolder+curFile
        try:
            if os.path.isfile(filepath):
                print(filepath)
                os.remove(filepath)
        except OSError:
            # Do nothing.
            filepath = ''

def processJpgs(tiffOutFolder, jpgOutFolder):
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

# This function MUST receive a date in the format 'YYYY-MM-DD' and a Time in the format 0-24
if __name__ == "__main__":

    args = sys.argv

    if len(args) < 3:
        tiffOutFolder = 'tiffs/'
        jpgOutFolder = 'images/'
        fileType= 'mextiff'
    else:
        tiffOutFolder = args[1]
        jpgOutFolder = args[2]
        fileType= args[3]

    # These are the different options someone can select
    fileTypes = {1:"geotiff", 2:"netcdf", 3:"mextiff", 4:"histmex"} 

    print("Folder to save tiff files:", tiffOutFolder)
    print("Folder to save jpg files:", jpgOutFolder)
    cnopts = pysftp.CnOpts()
    cnopts.hostkeys = None
    # Make the connection
    with pysftp.Connection(host,username=user,password=passw,cnopts=cnopts) as sftp:

        print("Reading data from ftp....")
        # Case for RGB geotiff
        if fileType == fileTypes.get(1):
            sftp.chdir('geotiff')
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
        downloadTiffImages(files,fileType, tiffOutFolder)

        processJpgs(tiffOutFolder, jpgOutFolder)
