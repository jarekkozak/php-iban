/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

yii.confirm = function (message, ok, cancel) {
    
    
    if ($(message).length > 0) {
        message = $(message).html();
    } else {
        message = '<h4><strong>' + message + '</strong></h4>';
    }

    var box = bootbox.confirm({message: message, show: false, callback: function (result) {
            if (result) {
                //yii.handleAction($e);
                !ok || ok();
            } else {
                !cancel || cancel();
            }
        }});

    box.on("show.bs.modal", function () {
        d = box.find('.modal-dialog');
        d.css({'width': '100%', 'margin': 'auto', 'position': 'absolute', 'top': '50%', 'left': '50%',
            '-webkit-transform': 'translate(-50%, -50%)',
            'transform': 'translate(-50%, -50%)'
        });
        //d.css({'width': '100%', 'margin': 'auto', 'position': 'absolute', 'top': 0, 'left': 0, 'bottom': 0, 'right': 0, 'height': 1});
        //d.css({'width': '100%', 'margin': 'auto', 'top': topMargin+'px', 'left': 0, 'right': 0, 'height': 1});
        d = box.find('.modal-body');
        d.css({'width': '50%', 'margin': 'auto', 'left': 0, 'right': 0});
        d = box.find('.modal-footer');
        d.css({'width': '50%', 'margin': 'auto', 'left': 0, 'right': 0});
        d = box.find('.modal-content');
        d.css({'background-color': 'black', 'color': 'white'});
    });
    box.modal('show');
    ion.sound.play("bell_ring");
    return false;
}
