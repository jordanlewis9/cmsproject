
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/scripts.js"></script>

</body>

<script>
$(document).ready(function(){
    ClassicEditor
        .create(document.querySelector('#body'))
        .catch(err => {
            console.error(err);
        })
})

</script>

</html>
