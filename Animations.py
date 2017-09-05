from pandas import DataFrame
from datetime import *
import matplotlib.pyplot as plt
import numpy as np

from netCDF4 import Dataset

gfsFile = Dataset("Mexico_2017.0824.154536.goes-16_C04_2km.nc", "r", format="NETCDF4")

# Read dimensions
dims = gfsFile.dimensions
#print(dims)

# Read variables
gfsVars = gfsFile.variables
# Print all the variables
keys = gfsVars.keys()
print(keys)
print(gfsVars.get(keys[1]))

varName = keys[0]
f = plt.figure(figsize=(15,10)) # Make  a larger plot
myVar = gfsVars.get(varName) #Reads the variable

# From the filtered data, we make the plot
#plt.imshow(myVar[:])
#plt.colorbar()
#plt.show()

gfsFile.close()
