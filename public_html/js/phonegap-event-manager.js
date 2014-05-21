var eventQueue = {};

function getEvents()
{
	var tempArray = eventQueue.slice();
	eventQueue = {};
	
	return tempArray;
}