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
    var seocounter_pros = 4000;
    var seocounter_cons = 4000;
    var seocounter_otros = 4000;
    $('.seocounter_pros, .seocounter_cons, .seocounter_otros').each(function(){
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
        if (s == 'pros') {s=seocounter_pros;}
        if (s == 'cons') {s=seocounter_cons;}
        if (s == 'otros') {s=seocounter_otros;}
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