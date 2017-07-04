function pageHeight(){ 
	if($.browser.msie){ 
		return document.compatMode == "CSS1Compat"? document.documentElement.clientHeight : document.body.clientHeight; 
	}else{ 
		return self.innerHeight; 
	} 
}; 
function pageWidth(){ 
	if($.browser.msie){ 
		return document.compatMode == "CSS1Compat"? document.documentElement.clientWidth : document.body.clientWidth; 
	}else{ 
		return self.innerWidth; 
	} 
}; 