PictureManager = function() {
    var self = this;

    /**
     * Init of the FileManage
     */
    self.init = function() {
        self.refreshContent();
    };

    self.refreshContent = function() {
        self.unBindEvents();
        self.bindEvents();
    };

    self.bindEvents = function() {

        $('.phyto').popover({
            'html': true,
            'trigger': 'hover'
        });

        $('.connectedSortable').sortable({
            connectWith: ".connectedSortable",
            placeholder: "ui-state-highlight",
            receive: function( event, ui ) {
                var newGroupId = ui.item.parents('tr').data('group-id');
                var currentId = ui.item.find('img').data('id');
                self.addPicToGroup(currentId, newGroupId);
                ui.item.attr('data-group-id', newGroupId);
            },
            remove: function( event, ui ) {
                var currentGroupId = ui.item.data('group-id');
                var currentId = ui.item.find('img').data('id');

                self.removePicFromGroup(currentId);
                console.log(currentId);

                var $currentGroup = $('.table').find('#group-'+currentGroupId);
                if($currentGroup.find('li.draggable').length == 0){
                    self.removeGroup(currentGroupId);
                    $currentGroup.remove();
                }
            }
        });

        $('.new-group').bind('click', self.createNewGroup);

        $('.delete-guy').bind('click', self.deleteGuy);

    };

    self.unBindEvents = function() {

        $('.new-group').unbind('click', self.createNewGroup);
        $('.delete-guy').unbind('click', self.deleteGuy);

    };

    /**
     * Remove completely a guy
     */
    self.deleteGuy = function(){
        var $tr = $(this).parents('tr');
        var $ul = $tr.find('ul.list-inline');
        var $lis = $tr.find('li.draggable');
        var $currentLi = $(this).parent('li.draggable');
        var idGroup = $currentLi.attr('data-group-id');
        var idGuy = $currentLi.find('img').attr('data-id');

        if($lis.length <= 1) {
            $tr.remove();
            self.removeGroup(idGroup);
        }
        else{
            $currentLi.remove();
        }

        $.ajax({
            type: "GET",
            url: "/delete-guy?id=" + idGuy,
        }) .done(function( msg ) {
        });

        return false;
    }

    /**
     * Remove a picture from a group
     */
    self.removePicFromGroup = function(picId){
        $.ajax({
            type: "GET",
            url: "/remove-pic-from-group?pic=" + picId,
        }) .done(function( msg ) {
        });
    }

    /**
     * Add a picture to a group
     */
    self.addPicToGroup = function(picId, groupId){
        $.ajax({
            type: "GET",
            url: "/add-pic-to-group?pic=" + picId + "&group=" + groupId,
        }) .done(function( msg ) {
        });
    }

    /**
     * Remove group
     */
    self.removeGroup = function(groupId){
        $.ajax({
            type: "GET",
            url: "/remove-group?group=" + groupId,
        }) .done(function( msg ) {
        });
    }

    /**
     * Create a new group for a guy
     */
    self.createNewGroup = function(){
        //var newGroupId = self.getNewGroup();
        var tr = $(this).parents('tr');
        var currentElement = $(this).parent('li');
        var currentUl = currentElement.parent('ul');
        if(currentUl.find('li').length == 1){
            alert("Cannot create group for one guy!");
        }
        else{
            var elementClone = currentElement.clone();
            var trClone = tr.clone();
            trClone.find('td:last > ul > li').remove();
            currentElement.remove();
            tr.after(trClone);
            $.ajax({
                type: "GET",
                url: "/create-group",
            }).done(function( msg ) {
                var groupid = msg.group;
                trClone.find('td:last > ul').append(elementClone);
                trClone.find('td:first').text(groupid);
                trClone.attr('data-group-id', groupid);
                trClone.attr('id', 'group-'+groupid);
                trClone.find('li.draggable').attr('data-group-id', groupid);
                self.addPicToGroup(elementClone.find("img").data('id'), groupid);
                self.refreshContent();
            }).fail(function(){
                alert("Oops there were something wrong");
            });
        }
        return false;
    }

    /**
     * Create a group
     */
    self.getNewGroup = function(){
        $.ajax({
            type: "GET",
            url: "/create-group",
        }) .done(function( msg ) {
            obj = jQuery.parseJSON(msg);
            groupid = obj.group;
            return groupid;
        });
        return 0;
    }

    self.init();


};

$( document ).ready(function() {
    new PictureManager();
});
