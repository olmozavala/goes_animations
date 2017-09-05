import pysftp
from pandas import DataFrame, Series
import pandas as pd
from datetime import datetime 

host = '132.247.103.143'
outputFolder = 'output'
user= 'usuarioext'
passw = 'conf$39p'

# Define which type of files we want to download
fileTypes = {1:"geotiff", 2:"netcdf"} 
fileType = "geotiff"

# This function MUST receive a date in the format 'YYYY-MM-DD' and a Time in the format 0-24
if __name__ == "__main__":
    # Make the connection

    with pysftp.Connection(host,username=user,password=passw) as sftp:

        sftp.cd('out')
        # Case for geotiff
        if fileType == fileTypes.get(1):
            sftp.chdir('geotiff')
        else:
        # Case for netcdf
            sftp.chdir('mexico_netcdf')

        currFiles = sftp.listdir()
        files = Series(currFiles)
        print(files)

        # Case for geotiff
        if fileType == fileTypes.get(1):
            data = [[row] for row in files]
            dates = [datetime.strptime(row.split('-')[0],"%Y.%m%d.%H%M%S.goes") for row in files]

            df = DataFrame(data,columns=['file'],index=dates)
            df = df.tail(3)
            for dfile in df.loc[:]['file']:
                print('Downloading file: ', dfile)
                sftp.get(dfile)
        else:
        # Case for netcdf
            data = [[row.split('_')[2],row] for row in files]
            dates = [datetime.strptime(row.split('_')[1],"%Y.%m%d.%H%M%S.goes-16") for row in files]

            df = DataFrame(data,columns=['band','file'],index=dates)

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

            # Obtain all the files from the 
            bands = ['C04']
            for band in bands:
                idx = df.loc[:]['band'].values == band
                # Download all the layers for selected band
                for dfile in df.loc[:]['file'][idx]:
                    print('Downloading file: ', dfile)
                    sftp.get(dfile)

                #idx = df.loc[datetime(2017,8,24,17):datetime(2017,8,24,17,15)]['band'].values == 'C03'
                #print(df.loc[datetime(2017,8,24,17):datetime(2017,8,24,17,15)]['file'][idx])
