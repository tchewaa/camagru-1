<?php $this->start('body'); ?>
<h1 class="test">Welcome to camagru 2.0</h1>
    <div onclick="ajaxTest();">Click me!!!</div>

    <script>
        function ajaxTest(){
            $.ajax({
                type: "POST",
                url : '<?=PROOT?>home/testAjax',
                data : {model_id:45},
                success : function(resp){
                    if(resp.success){
                        window.alert(resp.data.name);
                    }
                    console.log(resp);
                }
            });
        }
    </script>
<?php $this->end(); ?>