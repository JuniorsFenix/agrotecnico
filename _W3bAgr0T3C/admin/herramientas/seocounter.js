/**
 *                    SEO Counter
 *                ==================
 *
 * Copyright 2009 Harvey Kane <code@ragepank.com>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.ragepank.com/seocounter/
 *
 */

function seocounter(suffix)
{
    if (!suffix) {var suffix = '';}
    var seocounter_title = 70;
    var seocounter_meta = 200;
    $('.seocounter_title, .seocounter_meta').each(function(){
        var s = false;
        var c = $(this).attr('class');
        var a = c.split(' ');
        var r = /seocounter_(.*)/i;
        for(i=0; i<a.length; i++) {
            var m = r.exec(a[i]);
            if (m != null && m.length > 1) {
            	s = m[1];
            }
        }
        if (s == 'title') {s=seocounter_title-suffix.length;}
        if (s == 'meta') {s=seocounter_meta;}
        if ((s != false) && (!$('#seocounter_'+$(this).attr('name')).length)) {
            var l = s - $(this).val().length;
            $(this).after(' <span class="seocounter" id="seocounter_'+$(this).attr('name')+'">'+l+'</span>');
        		if (l < 0) {$('#seocounter_'+$(this).attr('name')).addClass('limit');}
            $(this).keyup(function(){
                var l = s - $(this).val().length;                
                $('#seocounter_'+$(this).attr('name')).html(l);
        		if (l < 0) {$('#seocounter_'+$(this).attr('name')).addClass('limit');}
        		if (l >= 0) {$('#seocounter_'+$(this).attr('name')).removeClass('limit');}
            });
        }
    });
}