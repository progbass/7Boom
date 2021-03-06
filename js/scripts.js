const Axios = require('../gulp/node_modules/axios');
const animateScrollTo = require('../gulp/node_modules/animated-scroll-to');
const DFPManager = require('./DFPManager');



/////////////////////////////////////////////////////////////
// SOCIAL SHARE
/////////////////////////////////////////////////////////////
window.socialshare = function(id, urlpost, titles){
	//properties
	var source = urlpost;
	var url="";
	
	
	//Choose Social Network
	switch(id){
		case 'facebook':
			url = 'https://www.facebook.com/sharer/sharer.php?u=' + source;
			break;
			
		case 'twitter':
			title = encodeURIComponent(titles);
			url = 'https://twitter.com/intent/tweet?text='+title+'&url='+source;
			break;
			
		default:
			break;
	}
	
	
	//Pop up settings
	var w = 500;
	var h = 250;
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	
	//open popup
	myWindow = window.open (url, 'win_share','width='+w+',height='+h+', top='+top+', left='+left);

	//
	return false;
};





(function(){
    let isMobile = true;
    let displayStateChanged = false;
    
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
                try{
                    const image = _target.querySelector('img');
                    image.onload = image.resize;
                    image.src = image.src;
                    image.resize();
                } catch(e) {}
			});
		});
	}
	let imagesList = [
		'#featured_articles .photo_container',
        '#latest_articles .article_container .photo_container',
        'aside .related ul .photo_container',
        '.article_container .latest_posts ul .photo_container'
	];
	resizeImages();
    
    
    
    let postsList = [];
    let posts_max = 15;
    function getPostsList(){
        const articleContainer = document.querySelector("#latest_articles .article_container");
        if(!articleContainer){
            return false
        }
        postsList = [].slice.call(articleContainer.querySelectorAll("li"));
    }
    function resetLayout(_grid, _length){
        var grid = _grid;
        
        const sequenceLength = _length;
        let iterationCount = 0;
        let counter = 0;
        const articleContainer = document.querySelector("#latest_articles .article_container");
        if(!articleContainer){
            return false
        }
        const thumbnails = postsList.slice(0, posts_max);
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
    getPostsList();
    resetLayout([ 2 ], 3);
    //resetLayout([ 2, 6 ]);
    
    
    
    const categories = ['9am-6pm', '6pm-8pm', '8pm-finde'];
    const header = document.querySelector('header');
    const menu_main = document.querySelector('#menu_main');
    const menu_mobile_icon = header.querySelector('ul.mobile_items .menu');
    menu_main.addEventListener('click', function(e){
        const button = e.target;
        
        if( base_reference.section === 'home' ){
            //
            try{
                let dynamicContent;
                for(let i=0; i<categories.length; i++){
                    var container_cat = 'menu-'+categories[i];
                    var parentContainer = button.parentNode;
                    
                    if(parentContainer.classList.contains(container_cat)){
                        dynamicContent = true;
                        break;
                    }

                    dynamicContent = false;
                }

                // 
                if(dynamicContent){
                    e.preventDefault();
                    
                    //
                    for(let i=0; i<categories.length; i++){
                        var parentContainer = menu_main.querySelector('li.menu-'+categories[i]);

                        //
                        if(parentContainer.classList.contains(container_cat)){
                            parentContainer.classList.add('current-menu-item');
                        } else {
                            parentContainer.classList.remove('current-menu-item');
                        }
                    }
                    
                    //
                    loadContent(container_cat.substring(5));
                    
                    const target = (header.offsetTop - header.scrollTop + header.clientTop);
                    animateScrollTo(target, {speed: 800});
                }

            } catch (error){}
            
            return;
        }
        
    });
    
    menu_mobile_icon.addEventListener('click', function(){
        header.classList.toggle('open')
    });
    
    
    
    
    /////////////////////////////////////////////////////////////
	// PAGINATION / VIEW MORE  AJAX 
	/////////////////////////////////////////////////////////////
	let loading_content = false;
	let loading_enabled = true;
	var sort_pagination_page = base_reference.actual_page;
	var sort_pagination_total = base_reference.total_pages;


	// Buttons
	function loadContent(_category){
		sort_pagination_page++;
        let _section = 'home';
		let container = document.querySelector('#latest_articles>ul');
        if( base_reference.section == 'single'){
            _section = 'single';
            container = document.querySelector('#single');
        }
		loadSortedContent( container, _category, _section );

		return false;
	};


	// Function
	function loadSortedContent(_container, _category, _section){
		loading_content = true;

		// Params
		let ajax_container = _container;

		// Pagination Checker
		/*if(sort_pagination_page >= sort_pagination_total){
			sort_pagination_page = sort_pagination_total;
			_paginator.fadeOut();
			loading_enabled = false;
		}*/
		
		// Show Preloader
		/*var preloader = document.createElement('div');
        preloader.className = 'preloader';
        ajax_container.innerHTML = '';
		ajax_container.append( preloader );*/
        
        
        // Make Ajax Call
        Axios.get(base_reference.ajaxurl, {
			params: {
				action: 'ajax_pagination_'+base_reference.section,
				query_vars: base_reference.query_vars,
				page: sort_pagination_page,
                category: _category
			}
        })
        .then(function (response) {
            loading_content = false;

            // Show Paginator
            /*if(sort_pagination_total > 1 && sort_pagination_page < sort_pagination_total){
                _paginator.fadeIn();
            }*/

            //remove preloader icon
            //preloader.parentNode.removeChild(preloader);

            // APPEND NEW ITEMS TO LIST
            var response_html = response.data;
            if(_section === 'single'){
                const fragment = new DOMParser().parseFromString(response_html, "text/html").body.firstChild;
                ajax_container.appendChild(fragment);
            } else {
                ajax_container.innerHTML = response_html;
            }

            // Setup Buttons and Image ratios
            resizeImages();
            getPostsList();
            resetLayout([ 2 ], 3);
            
            // Add Banners
            adsHandler.init();
        })
        .catch(function (error) {
            loading_content = false;
            console.log(error);
        });
	}
    
    
    
    
    
    
    ////////////////////////////////////////////////////////
	/// DYNAMIC DFP AD UNITS (LOAD ON EACH PAGINATION)
	////////////////////////////////////////////////////////
    let adsHandler;
	if(base_reference.section == 'single' || base_reference.section == 'home' || base_reference.section == 'category' ){
		adsHandler = new DFPManager(base_reference);
        adsHandler.init();
    }

    
    
    
    
    
    
    
    
    function onScroll(){
		const scrollPosition = document.body.scrollTop;

		// FIXED MENU 
		/*if(scrollPosition >= header_init_height ){
			header.classList.toggle('fixed', true);
			document.getElementById('main_container').style.paddingTop = header_init_height+'px';
		} else {
			header.classList.toggle('fixed', false);
			document.getElementById('main_container').style.paddingTop = '0px';
		}*/

		// AJAX CALLS
       	if(scrollPosition+window.innerHeight >= document.documentElement.offsetHeight){
       		if( loading_enabled && !loading_content && base_reference.section === 'single' ){
       			loadContent()
       		}
       	}
	}
    
    function onResize(){
        // Resize Responsive Images
        imagesList.forEach( function(item){
            const images = [].slice.call(document.querySelectorAll(item));
			images.forEach(function(_target){
                try{
                    const image = _target.querySelector('img');
                    image.resize();
                } catch(e) {}
			});
		});
        
        // Media Queries
        if(window.matchMedia("(max-width: 1100px)").matches){
            isMobile = true;
            displayStateChanged = true;
            posts_max = 15;
            
            resetLayout([ 2 ], 3);
        }else{
            isMobile = false;
            posts_max = 13;
            
            resetLayout([ 2 ], 3);
        }
    }
	window.addEventListener('scroll',  onScroll);
    window.addEventListener('resize', onResize)
    onResize();

})();