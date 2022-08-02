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
                                <option>100</option>
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

                            <!-- Range of difficulty slide -->
                            <label for="exampleFormControlSelect1">Difficulty</label>
                            <div class="range-slider">
                                <input id="difficultyValue" class="range-slider__range" type="range" value="1" min="1" max="100" step="1">
                                <span id="difficultyInfo" class="range-slider__value">1 movie among the 20 most popular movies of today</span>
                            </div>


                        </div>
                        <button id="submitParameters" class="btn btn-primary">Submit</button>
                    </div>

                    <div id="selectMovie" hidden>
                        <h3>Select a movie</h3>
                        <button id="loadMovie" type="button" class="btn btn-primary" >Generate a movie</button>
                        <button id="chooseMovie" type="button" class="btn btn-primary" disabled>Choose this movie</button>
                        <div id="displayMovie">
                            <h3>Movie Name:</h3>
                            <h4>Release Date:</h4>
                            <h4 id="synopsisContent">Synopsis:</h4>
                            <div id="moviePoster"></div>
                        </div>
                        <div id="movieError"></div>
                    </div>

                    <div id="selectWords" hidden>
                        <h3>Select your words</h3>
                        <button id="generateWords" type="button" class="btn btn-primary" >Generate words</button>
                        <button id="chooseWords" type="button" class="btn btn-primary" disabled>Choose these words</button>
                        <div id="wordsList"></div>
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
    var difficulty = 1;
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


    function getTMDBMovie(difficulty) {
        // get random number between 1 an 50 depending on difficulty
        var random = Math.floor(Math.random() * difficulty) + 1;
        // get most rated movie
        $.ajax({
            url: 'https://api.themoviedb.org/3/movie/top_rated?api_key=f284d86fabe6a583282b88a52798bdd6&language=en-US&page='+random,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // get a random movie
                var randomMovie = data.results[Math.floor(Math.random() * data.results.length)];
                // get the movie name
                var movieName = randomMovie.title;
                // get the release date
                var releaseDate = randomMovie.release_date;
                // get the movie poster
                var poster = "https://image.tmdb.org/t/p/w500" + randomMovie.poster_path;
                // get the synopsis
                var synopsis = randomMovie.overview;
                // set the movie name in the displayMovie div
                $('#displayMovie').html('<h3>Movie Name: ' + movieName + '</h3><h4>Release Date: ' + releaseDate + '</h4><h4 id="synopsisContent">Synopsis: ' + synopsis + '</h4><div id="moviePoster"><img src="' + poster + '" alt="' + movieName + '"></div>');

                }
        });

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
    // on change of difficulty slider
    $('#difficultyValue').change(function () {
        // get value of slider
        difficulty = $(this).val();
        // set value of difficultyInfo div
        $('#difficultyInfo').html('1 movie among the '+20*difficulty+' most popular movies of today');
    });

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
        // get difficulty
        difficulty = $('#difficultyValue').val();

    });

    // --- Select movie ---
    // on click on loadMovie button
    $('#loadMovie').click(function () {
        // activate button chooseMovie
        $('#chooseMovie').attr('disabled', false);

        // set attempts -1
        if (attempts == "Unlimited") {
            // nothing
        }else{
            attempts = attempts - 1;
        }
        // if attempts is not 0
        if (attempts != 0) {
            // loadMovie
            getTMDBMovie(difficulty);
            // Error message in MovieError div
            $('#movieError').html('<div class="alert alert-danger" role="alert">You have ' + attempts + ' attempts left</div>');

        } else {
            getTMDBMovie(difficulty);
            // display score div
            $('#selectWords').show();
            // hide selectMovie div
            $('#selectMovie').hide();
        }
    });

    // on click on chooseMovie button
    $('#chooseMovie').click(function () {
        // display selectWords div
        $('#selectWords').show();
        // hide selectMovie div
        $('#selectMovie').hide();
    });

    // on click on generateWords button
    $('#generateWords').click(function () {
        // get movie synopsis
        var synopsis = $('#synopsisContent').html();
        // put into array all words in synopsis (split by space) and remove all punctuation marks and numbers (replace with '') and lowercase all words (toLowerCase) and remove empty words (if length is 0) and remove duplicates (if length is 1) and remove words with length less than 5 characters (if length is less than 5) and remove the word 'synopsis word
       var originalWords = synopsis.split(' ').map(function (word) {
            return word.replace(/[^a-zA-Z]/g, '').toLowerCase();
        }).filter(function (word) {
            return word.length > 4;
        }).filter(function (word) {
            return word != 'synopsis';
        }).filter(function (word) {
            return word.length > 1;
        }).filter(function (word) {
            return word != '';
        });
        // activate button chooseWords
        $('#chooseWords').attr('disabled', false);

        // set words in wordsList div
        $('#wordsList').html('');
        // for each word in words array
        for (var i = 0; i < originalWords.length; i++) {
            // add word to wordsList div
            $('#wordsList').append('<div class="word" id="word'+i+'"><span class="wordName">' + originalWords[i] + '</span>');
        }

    });





</script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
