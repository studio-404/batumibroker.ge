// Initialize Cufon
Cufon.replace('.font').now();

function initialize()
{

    // Menu overs
    /*
    $('#t-menu li a').hover(function(){
        $(this).toggle();
    });
    */

    // Home menu
    $('#b-menu li').each(function(){
        $(this).children('div').first().mouseover(function(){
            var item = $(this).attr('class');
            $('#submenu > table').hide();
            $('#submenu table.' + item).show().mouseleave(function(){
                $(this).hide();
            });
        });
    });

    // Bottom menu
    $('#news-menu li').each(function(){
        $(this).children('div').first().mouseover(function(){
            var item = $(this).attr('class');
            $('#submenu1 > table').hide();
            $('#submenu1 table.' + item).show().mouseleave(function(){
                $(this).hide();
            });
        });
    });

    // Manual min-height
    var $text = $('#text-container'),
    text_minimum = 100;
    if ($text.height() < text_minimum)
        $text.height(text_minimum);

    // Search field
    var $search = $('#search-field'),
    search_value = $search.get(0).value;
    $search.focus(function(){
        if (this.value == search_value)
            $(this).val('');
    }).blur(function(){
        if (this.value == '')
            $(this).val(search_value);
    });

}

$(initialize);
