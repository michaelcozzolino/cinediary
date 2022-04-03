<p align="center">
    <a href="https://cinediary.tk" target="_blank">
        <img src="https://raw.githubusercontent.com/michaelcozzolino/cinediary/master/public/images/logo.png" width="1000" style='background-color: #262626'>
    </a>
</p>

## About Cinediary

Cinediary is a website that allows users to track movies and TV-series they have watched or
they would like to watch by adding them to specific lists called "diaries".
<br>
<br>
Some of its features are:

-   Data are taken by using the API of [themoviedb.org](https://themoviedb.org) .
-   The user is able to create custom diaries in addition to the main ones.
-   A statistics section where the user is able to get insights about his watched diary.
-   The website can be used in demo mode without the need for a registration.

You can view the website at [cinediary.tk](https://cinediary.tk) or you can run it locally:

-   Clone the repository: `git clone https://github.com/michaelcozzolino/cinediary.git`.
-   Install dependencies: `composer install`.
-   Rename the `.env.example` file to `.env` and configure it to your needs.
-   Seed the database: `php artisan db:seed`.
-   Compile Javascript & CSS: `npm run dev`.
-   Run the server: `php artisan serve`.
    <br>
    And finally...
-   Run tests: `php artisan test`.

### Code quality by <a href="https://github.com/nunomaduro/phpinsights">phpinsights</a>

<p align="center">
    <a href="https://www.cinediary.tk" target="_blank">
        <img src="https://raw.githubusercontent.com/michaelcozzolino/cinediary/master/public/images/phpinsights.png" width="600">
    </a>
</p>
