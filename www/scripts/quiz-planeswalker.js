
// Quiz result options in a separate object for flexibility
var resultOptions = [
    {   title: 'Chandler',
        desc: '<img width="312px" height="445px" src="https://goodgamery.com/wordpress/wordpress/wp-content/uploads/2015/01/chandler.jpg"/><p>You are Chandler! The finest thief in the plane of Ulgrotha (even better than Joven!), there\'s no end to the mischief you get up to. But it\'s all in good fun, right?</p>'},
    {   title: 'Anaba Shaman',
        desc: '<img width="312px" height="445px" src="https://goodgamery.com/wordpress/wordpress/wp-content/uploads/2015/01/anabashaman.jpg"/><p>You are Anaba Shaman! You can be fun to be around, but you\'re dangerous! If somebody gets on your bad side, BOOM - one damage. That\'s what they get for playing with fire.</p>'},
    {   title: 'Hazduhr the Abbot',
        desc: '<img width="312px" height="445px" src="https://goodgamery.com/wordpress/wordpress/wp-content/uploads/2015/01/HazduhrtheAbbot.jpg"/><p>You are Hazduhr the Abbot! It takes an organized mind to run the entire church of Serra. Some say your work leaves you with little time for a personal life, but you put the good of the church over even your own health.</p>'},
    {   title: 'Joven\'s Ferrets',
        desc: '<img width="312px" height="445px" src="https://goodgamery.com/wordpress/wordpress/wp-content/uploads/2015/01/JovensFerrets.jpg"/><p>You are Joven\'s Ferrets! A loyal friend and vicious, scratchy enemy, you\'re always "ferreting" out fun. During the six hours a day that you aren\'t sleeping, that is.</p>'},
    {   title: 'Grandmother Sengir',
        desc: '<img width="312px" height="445px" src="https://goodgamery.com/wordpress/wordpress/wp-content/uploads/2015/01/GrandmotherSengir.jpg"/><p>You are Grandmother Sengir! You are obsessed with power and uninterested in morality. Some call you insane, but you worked hard to become THE iconic female black-mana-using spellcaster of Magic, so forget the haters, girl!</p>'}
];

    
// global variables
var quizSteps = $('#quizzie .quiz-step'),
    totalScore = 0;

// for each step in the quiz, add the selected answer value to the total score
// if an answer has already been selected, subtract the previous value and update total score with the new selected answer value
// toggle a visual active state to show which option has been selected
quizSteps.each(function () {
    var currentStep = $(this),
        ansOpts = currentStep.children('.quiz-answer');
    // for each option per step, add a click listener
    // apply active class and calculate the total score
    ansOpts.each(function () {
        var eachOpt = $(this);
        eachOpt[0].addEventListener('click', check, false);
        function check() {
            var $this = $(this),
                value = $this.attr('data-quizIndex'),
                answerScore = parseInt(value);
            // check to see if an answer was previously selected
            if (currentStep.children('.active').length > 0) {
                var wasActive = currentStep.children('.active'),
                    oldScoreValue = wasActive.attr('data-quizIndex'),
                    oldScore = parseInt(oldScoreValue);
                // handle visual active state
                currentStep.children('.active').removeClass('active');
                $this.addClass('active');
                // handle the score calculation
                totalScore -= oldScoreValue;
                totalScore += answerScore;
                calcResults(totalScore);
            } else {
                // handle visual active state
                $this.addClass('active');
                // handle score calculation
                totalScore += answerScore;
                calcResults(totalScore);
                // handle current step
                updateStep(currentStep);
            }
        }
    });
});

// show current step/hide other steps
function updateStep(currentStep) {
    if(currentStep.hasClass('current')){
       currentStep.removeClass('current');
       currentStep.next().addClass('current');
    }
}

// display scoring results
function calcResults(totalScore) {
    // only update the results div if all questions have been answered
    if (quizSteps.find('.active').length == quizSteps.length){
        var resultsTitle = $('#results h1'),
            resultsDesc = $('#results .desc');
        
        // calc lowest possible score
        var lowestScoreArray = $('#quizzie .low-value').map(function() {
            return $(this).attr('data-quizIndex');
        });
        var minScore = 0;
        for (var i = 0; i < lowestScoreArray.length; i++) {
            minScore += lowestScoreArray[i] << 0;
        }
        // calculate highest possible score
        var highestScoreArray = $('#quizzie .high-value').map(function() {
            return $(this).attr('data-quizIndex');
        });
        var maxScore = 0;
        for (var i = 0; i < highestScoreArray.length; i++) {
            maxScore += highestScoreArray[i] << 0;
        }
        // calc range, number of possible results, and intervals between results
        var range = maxScore - minScore,
            numResults = resultOptions.length,
            interval = range / (numResults - 1),
            increment = '',
            n = 0; //increment index
        // incrementally increase the possible score, starting at the minScore, until totalScore falls into range. then match that increment index (number of times it took to get totalScore into range) and return the corresponding index results from resultOptions object
        while (n < numResults) {
            increment = minScore + (interval * n);
            if (totalScore <= increment) {
                // populate results
                resultsTitle.replaceWith("<h1>" + resultOptions[n].title + "</h1>");
                resultsDesc.replaceWith("<p class='desc'>" + resultOptions[n].desc + "</p>");
                return;
            } else {
                n++;
            }
        }
    }
}