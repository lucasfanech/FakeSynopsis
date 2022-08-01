<html>
    <head>
        <title>FakeSynopsis</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="players">
                        <h3>Create players</h3>
                        <!-- button add a player -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPlayer">
                            Add a player
                        </button>
                        <div id="playersList">

                        </div>
                        <div id="prepareToConfig">
                            <div class="alert alert-danger" role="alert">You must add at least one player</div>
                        </div>
                        <!-- modal add a player -->
                        <div class="modal fade" id="addPlayer" role="dialog">
                            <div class="modal-dialog">
                                <!-- modal content -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add a player</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                                            <div id="nameError"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="addPlayerButton">Add</button>
                                        <!-- button dismiss modal -->
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal add a player -->
                    </div>
                    <div id="parameters" hidden>
                        <div class="form-group">
                            <h3>Parameters</h3>
                            <label for="attempts">Number of attempts</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="attempts">
                                <option>1</option>
                                <option>2</option>
                                <option selected>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                            </select>

                            <label for="exampleFormControlSelect1">Duration</label>
                            <select class="form-control" id="duration" name="duration">
                                <option selected>Unlimited</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                            </select>
                        </div>
                        <button id="submitParameters" class="btn btn-primary">Submit</button>
                    </div>

                    <div id="selectMovie" hidden>
                        <h3>Select a movie</h3>
                        <button id="loadMovie" type="button" class="btn btn-primary" ></button>
                        <div id="displayMovie">
                            <h3>Movie Name:</h3>
                            <h4>Director:</h4>
                            <div id="moviePoster"></div>
                        </div>
                        <div id="movieError"></div>
                    </div>

                    <div id="selectWords" hidden>
                        <h3>Select your words</h3>
                    </div>

                    <div id="started" hidden>
                        <h3>Let's start your synopsis !</h3>
                    </div>

                    <div id="score" hidden>
                        <h3>Let's start your synopsis !</h3>
                    </div>
                </div>
            </div>
        </div>


    </body>
</html>
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script>
    var players = [];
    var attempts = 3;
    var duration = "Unlimited";
    function checkIfPlayersExist() {
        // if players array is empty
        if (players.length == 0) {
            // append error message in prepareToConfig div
            $('#prepareToConfig').html('<div class="alert alert-danger" role="alert">You must add at least one player</div>');
        } else {
            // append Configure button in prepareToConfig div
            $('#prepareToConfig').html('<button id="goToConfig" type="button" class="btn btn-primary" id="configure">Configure</button>');
        }
    }
    function loadMovie(){
        // get a random movie name
        var movieName = "Interstellar";
        // get a random director
        var director = "Christopher Nolan";
        // get a random poster
        var poster = "https://m.media-amazon.com/images/I/A1JVqNMI7UL._AC_SL1500_.jpg";
        // set the movie name in the displayMovie div
        $('#displayMovie').html('<h3>Movie Name: ' + movieName + '</h3><h4>Director: ' + director + '</h4><div id="moviePoster"><img src="' + poster + '" alt="poster"></div>');
    }

    // --- Players ---
    // on click on add player button
    $('#addPlayerButton').click(function () {
        // if name is not empty
        if ($('#name').val() != '') {
            // if name doesn't exist in players array
            if (players.indexOf($('#name').val()) == -1) {
                // add player to players array
                players.push($('#name').val());
                // get index of player in players array
                var index = players.indexOf($('#name').val());
                // add player to players list with delete button
                $('#playersList').append('<div class="player" id="player'+index+'"><span class="playerName">' + $('#name').val() + '</span><button id="deletePlayer" type="button" class="btn btn-danger deletePlayer">Delete</button></div>');
                // clear name input
                $('#name').val('');
                // dismiss modal
                $('#addPlayer').modal('hide');
                checkIfPlayersExist();
            } else {
                // if name already exists in players array
                $('#nameError').html('This name already exists');
            }
            // --- GO TO> Parameters ---
            // on click on goToConfig button
            $('#goToConfig').click(function () {
                // display parameters div
                $('#parameters').show();
                // hide prepareToConfig div
                $('#players').hide();
            });
        }
        else{
            // display error
            $('#nameError').html('Name is required');
        }
    });

    // on click on delete player button
    $(document).on('click', '.deletePlayer', function () {
        // get index of player in players array
        var index = players.indexOf($(this).parent().find('.playerName').html());
        // remove player from players array
        players.splice(index, 1);
        // remove player from players list
        $(this).parent().remove();
        checkIfPlayersExist();
    });

    // on click on modal remove display error
    $('#addPlayer').on('hidden.bs.modal', function () {
        $('#nameError').html('');
    });


    // --- Parameters ---
    // on click on submitParameters button
    $('#submitParameters').click(function () {
        // display selectMovie div
        $('#selectMovie').show();
        // hide parameters div
        $('#parameters').hide();

        // get number of attempts
        attempts = $('#exampleFormControlSelect1').val();
        // get duration
        duration = $('#duration').val();
    });

    // --- Select movie ---
    // on click on loadMovie button
    $('#loadMovie').click(function () {
        // set attempts -1
        if (attempts == "Unlimited") {
            // nothing
        }else{
            attempts = attempts - 1;
        }
        // if attempts is not 0
        if (attempts != 0) {
            // loadMovie
            loadMovie();
            // Error message in MovieError div
            $('#movieError').html('<div class="alert alert-danger" role="alert">You have ' + attempts + ' attempts left</div>');

        } else {
            loadMovie();
            // display score div
            $('#selectWords').show();
            // hide selectMovie div
            $('#selectMovie').hide();
        }
    });





</script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
