(function(){
    
	////////////////////////////////////////////////////////
	/// FORMAT IMAGES (VERTICAL/HORIZONTAL)
	////////////////////////////////////////////////////////
	
    // Extend Image Prototype Functionality
	Image.prototype.resize = function(){
		const container = this.parentNode;
		const containerRatio = container.offsetWidth / container.offsetHeight;
		const imageRatio = this.offsetWidth / this.offsetHeight;
		if(containerRatio > imageRatio){
			this.classList.remove('vertical');
			this.classList.add('horizontal');
		} else {
			this.classList.remove('horizontal');
			this.classList.add('vertical');
		}
	}

    
	function resizeImages(){
		// Add onLoadListener to Images
		imagesList.forEach( function(item){
            const images = [].slice.call(document.querySelectorAll(item));
			images.forEach(function(_target){
                const image = _target.querySelector('img');
                image.onload = image.resize;
                image.src = image.src;
                image.resize();
			});
		});
	}
	let imagesList = [
		'#featured_articles .photo_container',
        '#latest_articles .article_container .photo_container',
        'aside .recent-posts ul .photo_container'
	];
	resizeImages();
    
    
    
    
    function resetLayout(_grid, _length){
        var grid = _grid;
        
        const sequenceLength = _length;
        let iterationCount = 0;
        let counter = 0;
        const articleContainer = document.querySelector("#latest_articles .article_container");
        const thumbnails = [].slice.call(articleContainer.querySelectorAll("li"));
        let columnFlag = false;
        
        const cellPerColum = 2;
        let currentColumnCell = 0;
        var docfrag = document.createDocumentFragment();
        
        while (articleContainer.hasChildNodes()) {
            articleContainer.removeChild(articleContainer.lastChild);
        }
        
        thumbnails.forEach(function(_target, _index){
            if(_index != 0 && (_index % sequenceLength) == 0){
               iterationCount++;
            }          
            
            
            if(!columnFlag){
                for(var j = 0; j<grid.length; j++){
                    if(counter == grid[j]-1){
                        currentColumnCell = 0;
                        columnFlag = true;
                        
                        var col = document.createElement("div");
                        col.className = 'column';
                        col.appendChild(_target);
                        
                        try{
                            col.appendChild(thumbnails[_index+1]);
                        } catch(e){}
                        
                        docfrag.appendChild(col);
                    }
                }
                
                if(!columnFlag){
                    docfrag.appendChild(_target);
                }
            } else {
                
                currentColumnCell++;
                if(currentColumnCell >= cellPerColum-1){
                    //console.log('asdasd');  
                    columnFlag = false;
                }
            }
            
            counter++;
            if(counter > sequenceLength-1){
               counter = 0
            }
        });
        
        //
        articleContainer.appendChild(docfrag);
    }
    resetLayout([ 2 ], 3);
    //resetLayout([ 2, 6 ]);
    
    
    
    
    window.addEventListener('resize', function(){
        imagesList.forEach( function(item){
            const images = [].slice.call(document.querySelectorAll(item));
			images.forEach(function(_target){
                const image = _target.querySelector('img');
                image.resize();
			});
		});
    })


})();