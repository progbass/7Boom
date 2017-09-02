////////////////////////////////////////////////////////
/// DYNAMIC DFP AD UNITS (LOAD ON EACH PAGINATION)
////////////////////////////////////////////////////////
const DFPManager = function(_base_reference){
    var nextSlotId = 1;
    var base_reference = _base_reference || {};
    // this.nextSlotId = 1;
    // this.base_reference = _base_reference || {};
    // this.initFlag = false;
    // this.ignoredLoadListener = Array();
    
    
    
    
	function generateNextSlotName() {
		var id = nextSlotId++;
		return 'adslot' + id;
	}
    
	function init(){
        
        if(base_reference.section == 'single'){
            
            googletag.cmd.push(function() {
                
                // MOBILE & DESKTOP AD UNITS
                var aside_adContainers = [].slice.call(document.querySelector('#single').querySelectorAll('aside .banner_holder.box')).splice(-2, 2);
            
                var boxBanner1_container = aside_adContainers[0].querySelector('.ad_unit');
                boxBanner1_container.id = generateNextSlotName();
                var boxBanner2_container = aside_adContainers[1].querySelector('.ad_unit');
                boxBanner2_container.id = generateNextSlotName();
                
                
                var unit1_name,
                    unit2_name;
                switch(base_reference.category){
                case '9am-6pm': 
                    unit1_name = '/94465771/7boom_Boxbanner_1_9am';
                    unit2_name = '/94465771/7boom_Boxbanner_2_9am';
                    break;
                        
                case '6pm-8pm': 
                    unit1_name = '/94465771/7boom_Boxbanner_1_6pm';
                    unit2_name = '/94465771/7boom_Boxbanner_2_6pm';
                    break;
                        
                case '8pm-finde': 
                    unit1_name = '/94465771/7boom_Boxbanner_1_8pm';
                    unit2_name = '/94465771/7boom_Boxbanner_2_8pm';
                    break;
                }
                       
                var boxBanner1 = googletag.defineSlot(unit1_name, [[300, 250], [300, 300]], boxBanner1_container.id)
                .addService(googletag.pubads());
                var boxBanner2 = googletag.defineSlot(unit2_name, [[300, 250], [300, 300]], boxBanner2_container.id)
                .addService(googletag.pubads());

                googletag.display(boxBanner1_container.id);
                googletag.display(boxBanner2_container.id);
                googletag.pubads().refresh([boxBanner1, boxBanner2]);
                
                
                
                
                // ONLY MOBILE AD UNITS
                var banner_container,
                    slot,
                    unit3_name;
                if( base_reference.isMobile == 'true' ){
                    try {
                        var mobile_adContainer = [].slice.call(document.querySelector('#single').querySelectorAll('article .content_holder .ad_container')).splice(-1, 1);
                        banner_container = mobile_adContainer[0].querySelector('.ad_unit');
                        banner_container.id = generateNextSlotName();
                        
                        switch(base_reference.category){
                        case '9am-6pm': 
                            unit3_name = '/94465771/7boom_m_Boxbanner_9am';
                            break;

                        case '6pm-8pm': 
                            unit3_name = '/94465771/7boom_m_Boxbanner_6pm';
                            break;

                        case '8pm-finde': 
                            unit3_name = '/94465771/7boom_m_Boxbanner_8pm';
                            break;
                        }

                        slot = googletag.defineSlot(unit3_name, [[300, 300], [300, 250]], banner_container.id)
                        .addService(googletag.pubads());

                    } catch(e){}
                    

                    
                // ONLY DESKTOP AD UNITS
                } else {
                    try {
                        var billboard_adContainer = [].slice.call(document.querySelector('#single').querySelectorAll('.ad_container.full_width')).splice(-1, 1);
                        banner_container = billboard_adContainer[0].querySelector('.ad_unit');
                        banner_container.id = generateNextSlotName();
                        
                        switch(base_reference.category){
                        case '9am-6pm': 
                            unit3_name = '/94465771/7boom_Billboard_9am';
                            break;

                        case '6pm-8pm': 
                            unit3_name = '/94465771/7boom_Billboard_6pm';
                            break;

                        case '8pm-finde': 
                            unit3_name = '/94465771/7boom_Billboard_8pm';
                            break;
                        }

                        slot = googletag.defineSlot(unit3_name, [[728, 90], [970, 250]], banner_container.id)
                        .addService(googletag.pubads());

                    } catch(e){}

                }

                
                // Display Corresponding units
                if(banner_container){
                    googletag.display(banner_container.id);
                    googletag.pubads().refresh([slot]);
                }
            });		
        }
		
	}
    
    
    
	if(base_reference.section == 'single' || base_reference.section == 'home' || base_reference.section == 'category' )
		init();
    
    
    return {
        init
    }
}

    
    

module.exports = DFPManager;