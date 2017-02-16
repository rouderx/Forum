	<footer class="footer">
        <div class="container">
            <span>&copy; 2017 devrouder</span>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".navbar-t").mouseup(function(event) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
    		$("#new-q").slideToggle();
    	});

        $('#_more').click(function(event) {
            var dataO = {};
            dataO['content'] = $(this).attr('class');
            if(dataO['content'] == "_answers") dataO['id'] = getUrlParameter('id');
            $.ajax({
                type: "POST",
                url: "/loadMoreContent.php",
                data: dataO ,
                success: function(data) {
                    var log = jQuery.parseJSON(data);
                    if(dataO['content'] == "_threads"){
                        var obj = log.slice(0, log.length/3);
                        var usr = log.slice((log.length/3), 2*(log.length/3));
                        var com = log.slice((2*(log.length/3)), log.length);
                        if(obj.length > 0){
                            for (var i = 0; i < obj.length; i++){
                                var id = log[i].id;
                                var pid = log[i].P_id;
                                var napdis = log[i].t_nadpis;
                                var text = log[i].t_text;
                                var thread = '<div class="row col-md-offset-2 col-md-8 m-b p-a thread" onclick="window.location.href=\'/thread?id='+id+'\';"><div class="col-md-2 m-t-xs no-space-break"><a href="/profile?user='+usr[i]+'">'+usr[i]+'</a></div><div class="col-md-10"><div class="col-md-12"><label class="label-edit">'+napdis+'</label></div><div class="col-md-12">'+text+'</div><div class="col-md-12 text-right fs-sm">Komentáre: '+com[i]+'</div></div></div>';
                                $(thread).insertBefore("#more");
                            }
                            if(obj.length < 10){
                                $('#more').remove();
                            }
                        }
                    } else {
                        var obj = log.slice(0, log.length/2);
                        var usr = log.slice((log.length/2), log.length);
                        if(obj.length > 0){
                            for (var i = 0; i < obj.length; i++){
                                var text = log[i].a_text;
                                var date = log[i].date;
                                var thread = '<div class="row m-b-s"><div class="col-md-offset-3 col-md-6 fs-sm bg-c-lg ah">Komentoval: <a href="/profile?user='+usr[i]+'">"'+usr[i]+'"</a> dňa: "'+date+'</div><div class="col-md-offset-3 col-md-6"><div>'+text+'</div></div></div>';
                                $(thread).insertBefore("#more");
                            }
                            if(obj.length < 15){
                                $('#more').remove();
                            }

                        }
                    }
                }
            });
        });
    });

        function changeEmail(){
            var text = '<form method="post">'+
                '<div class="row col-sm-12 col-md-12 m-b-s">'+
                    '<label class="col-md-4">Starý e-mail:</label>'+
                    '<input class="col-md-4" type="text" name="old-mail" placeholder="Starý e-mail">'+
                '</div>'+
                '<div class="row col-sm-12 col-md-12 m-b-s">'+
                    '<label class="col-md-4">Nový e-mail:</label>'+
                    '<input class="col-md-4" type="text" name="new-mail" placeholder="Nový e-mail">'+
                '</div>'+
                '<div class="col-md-4 col-sm-2 col-md-offset-2 m-b">'+
                    '<input type="submit" name="submit" value="Zmeniť e-mail">'+
                '</div>'+
            '</form>';
            $("#email").empty();
            $("#email").prop('onclick',null).off('click');
            $("#email").html(text);
        }

        function changePass(){
            var text = '<form method="post">'+
                '<div class="row col-sm-12 col-md-12 m-b-s">'+
                    '<label class="col-md-4">Staré heslo:</label>'+
                    '<input class="col-md-4" type="password" name="old-pass" placeholder="Staré heslo">'+
                '</div>'+
                '<div class="row col-sm-12 col-md-12 m-b-s">'+
                    '<label class="col-md-4">Nové heslo:</label>'+
                    '<input class="col-md-4" type="password" name="new-pass" placeholder="Nové heslo">'+
                '</div>'+
                '<div class="col-md-4 col-sm-2 col-md-offset-2 m-b">'+
                    '<input type="submit" name="submit" value="Zmeniť heslo">'+
                '</div>'+
            '</form>';
            $("#pass").empty();
            $("#pass").prop('onclick',null).off('click');
            $("#pass").html(text);
        }

        function changeInfo(){
            var text = '<form method="post">'+
                '<div class="row col-sm-12 col-md-12 m-b-s">'+
                    '<label class="col-md-3">Zadaj popis:</label>'+
                    '<textarea id="textarea" class="col-md-5" type="text" name="info" placeholder="Zadaj text" maxlength="200"></textarea>'+
                '</div>'+
                '<div class="col-md-4 col-sm-2 col-md-offset-2 m-b">'+
                    '<input type="submit" name="submit" value="Zmeniť popis">'+
                '</div>'+
            '</form>';
            $("#info").empty();
            $("#info").prop('onclick',null).off('click');
            $("#info").html(text);
        }

        function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };

        $(".remove").click(function(e) {
            var id = $(this).data("id");
          
          $.post("/vymaz.php", JSON.stringify({"id": id}), function(data) {
            if(data == "true"){
                alert("Váš účet bol úspešne odstránený.");
                window.location.replace("http://sem.devrouder.cz/logout");
            }
          });
        });
        
    </script>
</body>
</html>