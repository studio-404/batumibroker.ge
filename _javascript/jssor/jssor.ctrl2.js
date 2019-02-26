jQuery(document).ready(function ($) {
    var _SlideshowTransitions = [
        {$Duration:800,$Delay:30,$Cols:4,$Rows:4,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:513,$Easing:$JssorEasing$.$EaseOutCubic,$Opacity:2},
        {$Duration:800,$Delay:30,$Cols:4,$Rows:4,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:264,$Easing:$JssorEasing$.$EaseOutCubic,$Opacity:2}
    ];
    var options = {
        $AutoPlay: true,                                    
        $AutoPlayInterval: 2500,                            
        $SlideDuration: 1200,                    
        $AutoPlaySteps: 3,                                  
        $ArrowKeyNavigation: true,
        $DragOrientation: 3,                        
            $SlideshowOptions: {                                
            $Class: $JssorSlideshowRunner$,                
            $Transitions: _SlideshowTransitions,            
            $TransitionsOrder: 1,                           
            $ShowLink: false                                    
        },                       
        // $DirectionNavigatorOptions: {
        //     $Class: $JssorDirectionNavigator$,              
        //     $ChanceToShow: 1,                               
        //     $AutoCenter: 2,                                 
        //     $Steps: 1                                       
        // },
        $NavigatorOptions: {                            
            $Class: $JssorNavigator$,                       
            $ChanceToShow: 2,                               
            $ActionMode: 1,                                 
            $AutoCenter: 0,                                 
            $Steps: 1,                                      
            $Lanes: 1,                                      
            $SpacingX: 0,                                   
            $SpacingY: 0,                                   
            $Orientation: 1                                 
        }
        // $CaptionSliderOptions: {                            
        //     $Class: $JssorCaptionSlider$,                   
        //     $CaptionTransitions: _CaptionTransitions,       
        //     $AutoCenter: 1,                                 
        //     $PlayInMode: 1,                                 
        //     $PlayOutMode: 3                                 
        // }
    };
    var jssor_slider1 = new $JssorSlider$("slider2", options);
    // function ScaleSlider() {
    //     var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
    //     if (parentWidth)
    //         jssor_slider1.$SetScaleWidth(parentWidth);
    //     else
    //         window.setTimeout(ScaleSlider, 10);
    // }
    // ScaleSlider();
    // if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
    //     $(window).bind('resize', ScaleSlider);
    // }
});