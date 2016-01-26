# Podcast Show Notes

This project has multiple aims:

- Make podcasts more accessible by providing a text-version of episodes.
- Provide show notes to reduce podcast producing times
- Provide improved search ability to discover relevant podcasts.

This project was built during the [Watson Dev Post Hack](http://watson.devpost.com/).


## Architecture

The system is architecture in a factory-style conveyor belt system.  Each podcast has a status and then a particular
service of the system is responsible for moving the podcast from one state to the next. 

### State Flow

- New
- Downloaded
- File Converted
- Audio to Text Converted

Each state (apart from new) has a failure state which is used to show if a podcast failed at this state. The service
responsible for this process can decide whether to retry podcasts in this process but by default these are end states. 


## Contributors

- [Nathan McBride](https://twitter.com/brideoweb)
- [Tom Robertshaw](https://twitter.com/bobbyshaw)

## License

This software is open-source and licensed under the [MIT license](http://opensource.org/licenses/MIT)
