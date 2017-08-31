////////////////////////////////////////////////////////
/// DYNAMIC DFP AD UNITS (LOAD ON EACH PAGINATION)
////////////////////////////////////////////////////////
const DFPManager = function(_base_reference){
    this.nextSlotId = 1;
    this.base_reference = _base_reference || {};
}
DFPManager.prototype.generateNextSlotName = function(){
    const id = this.nextSlotId++;
    return 'adslot' + id;
}


DFPManager.prototype.init = function(){
    this.createAdUnitContainer('init')
}


DFPManager.prototype.createAdUnitContainer = function(){
    
    googletag.cmd.push( () => {
        // Aside Container
        const aside = [].slice.call(document.querySelectorAll('aside')).splice(-1, 1)[0];

        // BOXBANNERS THAT LOADS ON AL PAGES
        const box1_all_container = document.createElement('div');
        box1_all_container.className = 'module ad_container';
        const box1_all = document.createElement('div');
        box1_all.id = this.generateNextSlotName();
        box1_all.className = 'ad_unit boxbanner';
        box1_all_container.appendChild(box1_all);
        let box1_slot = googletag.defineSlot('/94465771/7boom_Boxbanner_1_All', [[300, 300], [300, 250]], box1_all.id)
        .addService(googletag.pubads());
        
        const box2_all_container = document.createElement('div');
        box2_all_container.className = 'module ad_container';
        const box2_all = document.createElement('div');
        box2_all.id = this.generateNextSlotName();
        box2_all.className = 'ad_unit boxbanner';
        box2_all_container.appendChild(box2_all);
        let box2_slot = googletag.defineSlot('/94465771/7boom_Boxbanner_2_All', [[300, 300], [300, 250]], box2_all.id)
        .addService(googletag.pubads());
        
        
        if(this.base_reference.section == 'single'){
            aside.insertBefore(box1_all_container, aside.firstChild);
            aside.insertBefore(box2_all_container, aside.firstChild);
        } else {
            aside.append(box1_all_container);
            aside.append(box2_all_container);      
        }
        
        
        googletag.display(box1_all.id);
        googletag.display(box2_all.id);
        googletag.pubads().refresh([box1_slot, box2_slot]);
        
        // BOXBANNER THAT LOADS ONLY ON CATEGORIES
        if(this.base_reference.category){
            try{
                const box1_cat_container = document.createElement('div');
                box1_cat_container.className = 'module ad_container';
                const box1_cat = document.createElement('div');
                box1_cat.id = this.generateNextSlotName();
                box1_cat.className = 'ad_unit boxbanner';
                box1_cat_container.appendChild(box1_cat);
                aside.insertBefore(box1_cat_container, aside.firstChild);
                
                const box2_cat_container = document.createElement('div');
                box2_cat_container.className = 'module ad_container';
                const box2_cat = document.createElement('div');
                box2_cat.id = this.generateNextSlotName();
                box2_cat.className = 'ad_unit boxbanner';
                box2_cat_container.appendChild(box2_cat);
                aside.insertBefore(box2_cat_container, aside.firstChild);
                
                let unit1, unit2;
                switch(this.base_reference.category){
                case '9am-6pm': 
                    unit1 = '/94465771/7boom_Boxbanner_1_9am';
                    unit2 = '/94465771/7boom_Boxbanner_2_9am';
                    break;

                case '6pm-8pm': 
                    unit1 = '/94465771/7boom_Boxbanner_1_6pm';
                    unit2 = '/94465771/7boom_Boxbanner_2_6pm';
                    break;

                case '8pm-finde': 
                    unit1 = '/94465771/7boom_Boxbanner_1_8pm';
                    unit2 = '/94465771/7boom_Boxbanner_2_8pm';
                    break;
                }

                box1_slot = googletag.defineSlot(unit1, [[300, 300], [300, 250]], box1_cat.id)
                .addService(googletag.pubads());
                box2_slot = googletag.defineSlot(unit2, [[300, 300], [300, 250]], box2_cat.id)
                .addService(googletag.pubads());

                googletag.display(box1_cat.id);
                googletag.display(box2_cat.id);
                googletag.pubads().refresh([box1_slot, box2_slot]);
            } catch(e){}
        }

        

        // ONLY DESKTOP AD UNITS
        if( this.base_reference.isMobile == 'false' ){
            try {
                // Get Billboard Container
                const adContainer = [].slice.call(document.querySelectorAll('.ad_container.full_width')).splice(-1, 1)[0];
                
                
                // BILLBOARD THAT LOADS ON AL PAGES
                const billboard_all = document.createElement('div');
                billboard_all.id =  this.generateNextSlotName();
                billboard_all.className = 'ad_unit billboard';
                adContainer.appendChild(billboard_all);
                
                let billboard_slot = googletag.defineSlot('/94465771/7boom_Billboard_all', [[728, 90], [970, 250]], billboard_all.id)
                .addService(googletag.pubads());
                googletag.display(billboard_all.id);
                googletag.pubads().refresh([billboard_slot]);
                
                
                
                // BILLBOARD THAT LOADS ONLY ON CATEGORIES
                if(this.base_reference.category){
                    const billboard_categories = document.createElement('div');
                    billboard_categories.id = this.generateNextSlotName();
                    billboard_categories.className = 'ad_unit billboard';
                    adContainer.appendChild(billboard_categories);

                    switch(this.base_reference.category){
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

                    billboard_slot = googletag.defineSlot(unit3_name, [[728, 90], [970, 250]], billboard_categories.id)
                    .addService(googletag.pubads());
                    
                    googletag.display(billboard_categories.id);
                    googletag.pubads().refresh([billboard_slot]);
                }

            } catch(e){}

        }
    });

    if(this.base_reference.section == 'single'){
        googletag.cmd.push( () => {

            // ONLY MOBILE AD UNITS
            if( this.base_reference.isMobile == 'true' ){
                try {
                    var mobile_adContainer = [].slice.call(document.querySelector('#single').querySelectorAll('article .content_holder .ad_container')).splice(-1, 1);
                    let banner_container = mobile_adContainer[0].querySelector('.ad_unit');
                    banner_container.id = this.generateNextSlotName();

                    let unit_name;
                    switch(this.base_reference.category){
                    case '9am-6pm': 
                        unit_name = '/94465771/7boom_m_Boxbanner_9am';
                        break;

                    case '6pm-8pm': 
                        unit_name = '/94465771/7boom_m_Boxbanner_6pm';
                        break;

                    case '8pm-finde': 
                        unit_name = '/94465771/7boom_m_Boxbanner_8pm';
                        break;
                    }

                    const slot = googletag.defineSlot(unit_name, [[300, 300], [300, 250]], banner_container.id)
                    .addService(googletag.pubads());
                    
                    googletag.display(banner_container.id);
                    googletag.pubads().refresh([slot]);

                } catch(e){}

            }
                
        });		
    }
}

    

module.exports = DFPManager;