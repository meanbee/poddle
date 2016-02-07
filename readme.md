# Podcast Show Notes

This project has multiple aims:

- Make podcasts more accessible by providing a text-version of episodes.
- Provide show notes to reduce podcast producing times
- Provide improved search ability to discover relevant podcasts.

This project was built during the [Watson Dev Post Hack](http://watson.devpost.com/).

## Dependencies

- libav
- opus-tools

## System Architecture

The system is architected in a factory-style conveyor belt system.  Each podcast has a status and then a particular
service of the system is responsible for moving the podcast from one state to the next.

### State Flow

- New
- Downloaded
- File Converted
- Audio to Text Converted

Each state (apart from new) has a failure state which is used to show if a podcast failed at this state. The service
responsible for this process can decide whether to retry podcasts in this process but by default these are end states.


### Commands

Get started by imported some RSS podcast feeds into your database

    php artisan db:seed
    
    
Then, on a regular basis, we should be running the following:

Synchronise RSS feeds and import any new podcast episodes

    php artisan podcast:sync
   
We will then wish to download new episodes

    php artisan podcast:download
    
Downloaded episodes can then be converted to opus format

    php artisan podcast:convertToOpus
    
Convert these opus files to text thanks to IBM Watson

    php artisan ibm:speechToText
    
Once we have text, we can then get podcast concets

    php ibm:conceptInsights
    
### Notes

Note that the site is running on Heroku and so we face two challenges

- Getting opus converstion working (@TODO)
- Download, convert, speech to text needs to be done in the same request to avoid losing the file (ephemeral file-system)
 
## Frontend

We use gulp independently of Elixir to manage the frontend.  To re-compile: 

    cd public/assets/
    gulp styles
    gulp images
    gulp watch

## Contributors

- [Nathan McBride](https://twitter.com/brideoweb)
- [Tom Robertshaw](https://twitter.com/bobbyshaw)

## License

This software is open-source and licensed under the [MIT license](http://opensource.org/licenses/MIT)
