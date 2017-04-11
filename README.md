# Apache Server Status Parser Component for PHP

This project aims to deliver an easy to use component to read the apache server status for a configured list of hosts and gain information about that.

This component is relying on the [apache mod_status](https://httpd.apache.org/docs/2.2/mod/mod_status.html) and the undocumented query "[?notable](https://www.cyberciti.biz/faq/apache-server-status/)" ("?auto" does not contain information about the pid).

# Project Goals

* provides simple access to process information (deals with strings)
* provides detailed access to all information (building a lot of objects)

# Why?

Let me give you an scenario I got on my desk and had to solve it.

## Given

As a maintainer of an infrastructure with multiple apache HTTP servers, I need to know if a given process (identified by its pid, a infrastructure wide unique identifier and its uri) is still running or not.
Sometimes I know the IP Address of the server where process is running, mostly all I have is a pid, the unique identifier and the uri.
And finally, it is allowed to use the apache server status but no ssh command execution.

# How To Use

Because of the shipped with builders, it is really easy to getting started with.
If you want to use your application instance pooling, use the builders as manual how to plumper things together.

There are two different kind of builders, one (AbstractStorageBuilder) gives you the control over where to fetch and how much to fetch information.
The second one (ParserBuilder) simple uses the result from the first one to parse the information into domain objects.

```php
//If you want to parse the whole apache server status
//  and create domain objects out of the information.

//begin of dependencies
$parserBuilderFactory       = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder\ParserBuilderFactory();
$storageBuilder             = new \Net\Bazzline\Component\ApacheServerStatusParser\Service\Builder\RemoteStorageBuilder();

$parserBuilder  = $parserBuilderFactory->create();
//end of dependencies

//begin of business logic
//  the following five logical lines are doing the trick
$storageBuilder->setUrlToTheApacheStatusFileToParseUpfront('<the url to your apache server status>');
$storageBuilder->selectParseModeAllUpfront();

$storageBuilder->build();

$parserBuilder->setStorageUpfront(
    $storageBuilder->andGetStorageAfterTheBuild();
);
$parserBuilder->build();

//  and now, do something with the result
var_dump(
    $parserBuilder->andGetListOfDetailOrNullAfterwards()
);
var_dump(
    $parserBuilder->andGetInformationOrNullAfterwards()
);
var_dump(
    $parserBuilder->andGetScoreboardOrNullAfterwards()
);
var_dump(
    $parserBuilder->andGetStatisticOrNullAfterwards()
);
//end of business logic
```

# Example

Examples are placed in the path <project root>/example. Because of the two implemented content fetchers, they are devide into the two categories "local" and "remote".

## Example Using Local File

```
#if no file path is provided, the shipped with example file will be used
#parse all
<project root>/example/local/parse_all.php [<path to the apache status file to parse>]
#parse detail only
<project root>/example/local/parse_detail_only.php [<path to the apache status file to parse>]
```

## Example Using Remote File

```
#if no file path is provided, the build in example url will be used
#parse all
<project root>/example/remote/parse_all.php [<url to the apache status page>]
#parse detail only
<project root>/example/remote/parse_detail_only.php [<url to the apache status page>]
```

# Workflow

* get content
* split content into dedicated sections
    * detail
    * information
    * scoreboard
    * statistic
* parse each section into its fitting domain object

# List Of Domain Model

* DomainModel\Detail
    * dynamic detail information about each worker
* DomainModel\Information
    * general static information about the environment
* DomainModel\Scoreboard
    * dynamic and general worker information
* DomainModel\Statistic
    * dynamic server statistic

# List Of Service

* Service\Builder
    * contains builder classes to kickstart the usage of this component
* Service\Content\Fetcher
    * contains classes to get the apache status content from somewhere
* Service\Content\Parser
    * contains classes to create domain objects out of the content
* Service\Content\Processor
    * contains the class to split the content into logical parts (does the heavy lifting)
* Service\Content\Storage
    * contains classes to share the logical content parts
* Service\StateMachine
    * contains a class to ease up splitting the content into logical parts

# Future Improvements

## To Do

* add example output
* create dedicated repository
* create release history
* write unit test
    * DetailListOfLineParser
    * Processor
    * ScoreboardListOfLineParser
    * SectionStateMachine
    * StatisticListOfLineParser
    * Storage
 * add the cool stuff from [here](https://github.com/bjhale/apache-status/blob/master/ApacheStatus.php) and [there](https://github.com/TomCan/server-status-parser) to this list (project steel with eyes wide open)

## Done

* added how to section
* created
    * HttpFileFetcher
    * Service/Builder section
* example written
    * local (using FileFetcher)
        * parse all (uses the FullStorage)
        * parse detail only (uses the DetailOnlyStorage)
    * remote (using HttpFetcher)
        * parse all (uses the FullStorage)
* unit test written
    * DetailOnly
* parser and domain object written
    * information
    * scoreboard
    * statistic

# Notes

Thanks to:
* [mod_status_parser](https://github.com/nikos-glikis/mod_status_parser)
* [determine if an apache process is still running](http://artodeto.bazzline.net/archives/846-determine-if-an-apache-process-is-still-running-via-bash-to-prevent-multiple-instances-running.html)
* [apache for the cloud](http://people.apache.org/~jim/presos/ACNA11/Apache_httpd_cloud.pdf)
* [reading apache server status](https://answers.splunk.com/answers/28058/reading-apache-server-status-output.html)
* [Apache Server Status](https://www.phpclasses.org/browse/file/17516.html)
