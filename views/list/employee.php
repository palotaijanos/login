<div id="list-table">
</div>

<script type="text/javascript">
    $(document).ready(function () {
        loadTableContent("index.php?page=<?=$currentPage?>&ajax=1");

        $(document).on('click','.paginate_link',function (e){
            e.preventDefault();
            var url = $(this).attr('href')+"&ajax=1";
            loadTableContent(url);
        });

        $(document).on('click','.orderby_link',function (e){
            e.preventDefault();
            var url = $(this).attr('href')+"&ajax=1";
            loadTableContent(url);
        });

        $(document).on('keyup','.filter_input',function (e){
            e.preventDefault();
            var filter_column = $(this).attr('name');
            var filter_value = $(this).val();

            setTimeout(function (){
                var url = "index.php?page=1&ajax=1&filter_column="+filter_column+"&filter_value="+filter_value;

                loadTableContent(url);
            }, 2000);
        });

    } );

    function loadTableContent(url){
        $.ajax({
            url: url,
            success: function(result){
                if(result != ''){
                    $('#list-table').html(result);
                }else{
                    console.log('no content');
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    }
</script>
