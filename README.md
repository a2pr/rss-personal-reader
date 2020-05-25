This little project will be use as a webpage which bring every post from the sources you give. You only need to run it 
with your local server and then accessing the index page. 
To change the sources you will need to change this variable in rss.php file
```
$newsSource = [
        [
            'title' => Title of the source,
            'url' => rss url
        ],
    ];
```

For MangaDex you can get it, in https://mangadex.org/follows in when clicking the rss icon. 
For reddit you only need the url of the place that receives the posts. i use a specific query in this project.

