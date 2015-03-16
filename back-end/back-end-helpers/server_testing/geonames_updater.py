#!/usr/bin/env python
from pymongo import MongoClient
from pymongo import GEOSPHERE
import time
# client = MongoClient() #will connect on the default host and port.
# We can also specify the host and port explicitly, as
#follows.
# Or use the MongoDB URI format
client = MongoClient('localhost', 27017)


def getGeoNameFile(fileName='LK.txt'):
    return open(fileName, 'r')


def createMongoHash(splitedList):
    """The main 'geoname' table has the following fields :
    ---------------------------------------------------
    [0]geonameid         : integer id of record in geonames database
    [1]name              : name of geographical point (utf8) varchar(200)
    [2]asciiname         : name of geographical point in plain ascii characters, varchar(200)
    [3]alternatenames    : alternatenames, comma separated, ascii names automatically transliterated, convenience attribute from alternatename table, varchar(8000)
    [4]latitude          : latitude in decimal degrees (wgs84)
    [5]longitude         : longitude in decimal degrees (wgs84)
    [6]feature class     : see http://www.geonames.org/export/codes.html, char(1)
    [7]feature code      : see http://www.geonames.org/export/codes.html, varchar(10)
    [8]country code      : ISO-3166 2-letter country code, 2 characters
    [9]cc2               : alternate country codes, comma separated, ISO-3166 2-letter country code, 60 characters
    [10]admin1 code       : fipscode (subject to change to iso code), see exceptions below, see file admin1Codes.txt for display names of this code; varchar(20)
    [11]admin2 code       : code for the second administrative division, a county in the US, see file admin2Codes.txt; varchar(80) 
    [12]admin3 code       : code for third level administrative division, varchar(20)
    [13]admin4 code       : code for fourth level administrative division, varchar(20)
    [14]population        : bigint (8 byte int) 
    [15]elevation         : in meters, integer
    [16]dem               : digital elevation model, srtm3 or gtopo30, average elevation of 3''x3'' (ca 90mx90m) or 30''x30'' (ca 900mx900m) area in meters, integer. srtm processed by cgiar/ciat.
    [17]timezone          : the timezone id (see file timeZone.txt) varchar(40)
    [18]modification date : date of last modification in yyyy-MM-dd format"""

    hashTemplate = {
        '_id': int(splitedList[0]),  #geonameid
        'name': splitedList[1],
        'asciiname': splitedList[2],
        'alternatenames': splitedList[3],
        'location': createGeoJson('Point', float(splitedList[5]), float(splitedList[4])),
        'feature_class': splitedList[6],
        'feature_code': splitedList[7],
        'elevation': splitedList[15],
        'dem': splitedList[16]
    }
    return hashTemplate


def insertToMongoDb(jsonLikeHash, dataBase='lk'):
    return client.geo_names[dataBase].insert(jsonLikeHash)


debugObject = None


def main():
    fileName = 'LK.txt'
    dataBase = 'lk_test'
    print "Start inserting data from {} file to {} database......".format(fileName, dataBase)
    geoNames = getGeoNameFile(fileName)
    recordsCount = 0
    startTime = time.time()
    for line in geoNames:
        recordsCount += 1
        line = line.strip()
        dataList = line.split('\t')  # Assuming data is comma seperated
        mongoHash = createMongoHash(dataList)
        mongoObjectId = insertToMongoDb(mongoHash, dataBase)
        #print "mongoObjectId {} added to Db sucsussfully.".format(mongoObjectId)
    endTime = time.time()
    print "Creating location index using R-Tree..."
    client.geo_names[dataBase].create_index([('location',
                                              GEOSPHERE )])  # pymongo.GEOSPHERE = '2dsphere' more info http://stackoverflow.com/questions/16908675/does-anyone-know-a-working-example-of-2dsphere-index-in-pymongo
    print "{} records from {} sucsussfully added to {} in {} seconds.".format(recordsCount, fileName, dataBase,
                                                                              (endTime - startTime))


def createGeoJson(geoJsonType, longitude, latitude):
    if not geoJsonType.lower() == "point":
        raise Exception("GeoJson type {} not supported!".format(geoJsonType))

    return {
        'point': {'type': geoJsonType.capitalize(), 'coordinates': [longitude, latitude]},
        'linestring': None,
    }.get(geoJsonType.lower(), None)


if __name__ == '__main__':
    main()