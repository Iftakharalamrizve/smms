<script>
    function checkUncheckAll(className, target){
        var clist=document.getElementsByClassName( className );
        let isChecked = '';
        
        if( target.checked ){
            isChecked = 'checked';
        }
        
        for(var i = 0; i < clist.length; ++i){
            clist[i].checked = isChecked;
        }
    }
</script>