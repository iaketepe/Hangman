# Hangman 

### Developing the app
This is our hangman game, coded in PHP, HTML, JS and CSS, as well as SQL usage for the database. In order to get started, first we had to install PHP and Postgres.

Inside Postgres' PGAdmin, we created a Leaderboard Schema. Inside that, we created a Leaderboard Table, which holds both the player's name and score. The table holds the ten top-scoring entries.

Additionally, we added the php.ini file to the php folder.

### Playing the game as a user
When you launch the game, you'll see something like this.
![Image of the launch screen of the game, featuring a leaderboard composed of many silly-named entries as well as many Natalies.](Assets/image.png)

At the top of the page is the title, as well as the start screen. You'll need to enter a username before you can play.
![A zoomed in image of the title screen, omitting the leaderboard. "NATALIE" is entered in the username entry box.](Assets/image-1.png)

Once you're in the game, it'll look like this.![A white box at the top holds five underlines to denote the five-letter word attempting to be guessed. A smaller white placeholder box for the hanged man is next to it. Below them both is a brown keyboard with black keys.](Assets/image-2.png)

The underlines in the top box indicate your progress on the word. In this case, we can tell the word has five letters. The smaller white box on its right will hold the hanged man upon incorrect letter guesses.
When you're ready to guess, click on any letter on the keyboard. For demonstrative purposes, I'll pick E.![A similar image to above, but with the E key highlighted in red and a head now in the hanged man box.](Assets/image-3.png)

Unfortunately, E was an incorrect guess. But that's okay! We still have more guesses. For my next guess, I'll do I.![Another similar image, but with I highlighted in green and the second underline replaced with an I](Assets/image-4.png)

A correct guess! "I" was the second letter of the word.
Let's keep guessing until we either win or lose.![The word was "Zilch." A, E, and P are all highlighted in red on the keyboard. A pop-up with the message saying "You won!" is on the screen.](Assets/image-5.png)

If you win with a high enough score, your score will be added to the leaderboard.![An updated leaderboard. This game's score, 20000, has been added to the leaderboard in 5th place, with the username NATALIE.](Assets/image-6.png)


### Admin Login:

Administrator’s start on the same page as user index.php
![Image of Homepage with Admin login Section](Assets/image-7.png)



Administrator will type their credentials into the “Admin Login” section.
![Image of credentials inputed into the Admin login Section](Assets/image-8.png)





A GET request will be sent to verify the administrator's credentials to the server via hangman-api.php. The end result for correct credentials will be a redirect based on a url sent by the server. 

![Image of Admin page redirect](Assets/image-9.png)





This section allows administrators to delete users on the server.

![Resulting Image after Administrator deletes users](Assets/image-10.png)


It also allows administrators to return to the home page, either to play the game themselves or to review the changes to the leaderboard end users will see.

![Image of returning to the homepage with updated Leaderboard](Assets/image-11.png)
