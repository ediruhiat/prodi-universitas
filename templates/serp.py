#!C:\Users\Edi\AppData\Local\Programs\Python\Python39\python.exe
import sys
import json
from pprint import pprint
from scholarly import scholarly

dosen = next(scholarly.search_author('Steven A. Cholewiak'))
arg = sys.argv[0]

pprint(arg)