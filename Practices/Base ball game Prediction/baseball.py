
import sys, os, operator
import re

def isBatter(name):
    if name in batters:
    	return True

def eachBatterAdd(name,batted,hits):
	batterBool = isBatter(name)
	if batterBool is True:
		batters[name][1] += batted
		batters[name][2] += hits
	else:
		batters[name] = [name,batted,hits]

def generateSortedList(batters):
	for batter in batters:
  		avg = float(batters[batter][2]) / float(batters[batter][1])
  		sorted_batters.append((batter, avg))
	return sorted_batters

def printResult(sorted_batters):
	for batter2 in sorted_batters:
		print("{0}: {1:.3f}".format(batter2[0], batter2[1]))

# Command-Line Arguments, fixed structure code imported from courseWiki-Python
#filepath = input("filepath?")
if (len(sys.argv) < 2):
	sys.exit("Usage: {sys.argv[0]} requires at least one argument for the file name ")

filename = sys.argv[1]

if not os.path.exists(filename):
    sys.exit(f"Error: File '{sys.argv[1]}' not found")

#the regulation expression according to data files,
regex = re.compile('(?P<name>[\w\s]+)\sbatted\s(?P<batted>\d*) times with (?P<hits>\d*) hits and (?P<runs>\d*) runs')

# Data
batters = {}
sorted_batters = []

#File I/O, fixed structure code imported from courseWiki-Python
file = open(filename, "r")

for line in file:
	result = re.match(regex,line)
	if result:
		batter_name = result.group('name')
		batter_bats = int(result.group('batted'))
		batter_hits = int(result.group('hits'))
		eachBatterAdd(batter_name,batter_bats,batter_hits)

file.close()

#Sorting, fixed structure code imported from courseWiki-Python
sorted_list = generateSortedList(batters)

sorted_batters = sorted(sorted_list, reverse=True, key=lambda batter: batter[1])
printResult(sorted_batters)
  
