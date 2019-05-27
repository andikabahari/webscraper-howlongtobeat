# webscraper-howlongtobeat

## Usage

### Get game detail by id

#### Example
```php
<?php

require_once __DIR__ . '/src/HowLongToBeat.php';

$howlongtobeat = new HowLongToBeat();

// Get game detail
$id = 46445;
$jsonMode = TRUE;
print_r($howlongtobeat->get($id, $jsonMode));
```

#### Result
```json
{
    "title": "Ni no Kuni II: Revenant Kingdom",
    "main_story": "37 Hours",
    "main_extra": "52 Hours",
    "completionist": "90&#189; Hours",
    "all_styles": "52&#189; Hours",
    "image": "https:\/\/howlongtobeat.com\/gameimages\/46445_Ni_No_Kuni_II_Revenant_Kingdom.jpg"
}
```

### Search for game details by title

#### Example
```php
<?php

require_once __DIR__ . '/src/HowLongToBeat.php';

$howlongtobeat = new HowLongToBeat();

// Search for game details
$title = 'Ni no Kuni';
$jsonMode = TRUE;
$limit = 5;
print_r($howlongtobeat->search($title, $jsonMode, $limit));
```

#### Result
```json
[
    {
        "title": "Ni no Kuni II: Revenant Kingdom",
        "main_story": "37 Hours",
        "main_extra": "52 Hours",
        "completionist": "90&#189; Hours",
        "all_styles": "52&#189; Hours",
        "image": "https:\/\/howlongtobeat.com\/gameimages\/46445_Ni_No_Kuni_II_Revenant_Kingdom.jpg"
    },
    {
        "title": "Ni no Kuni II: Revenant Kingdom",
        "main_story": "37 Hours",
        "main_extra": "52 Hours",
        "completionist": "90&#189; Hours",
        "all_styles": "52&#189; Hours",
        "image": "https:\/\/howlongtobeat.com\/gameimages\/46445_Ni_No_Kuni_II_Revenant_Kingdom.jpg"
    },
    {
        "title": "Ni no Kuni: Wrath of the White Witch",
        "main_story": "45&#189; Hours",
        "main_extra": "56&#189; Hours",
        "completionist": "93&#189; Hours",
        "all_styles": "57&#189; Hours",
        "image": "https:\/\/howlongtobeat.com\/gameimages\/2412937-box_nnk_large.png"
    },
    {
        "title": "Ni no Kuni: Wrath of the White Witch",
        "main_story": "45&#189; Hours",
        "main_extra": "56&#189; Hours",
        "completionist": "93&#189; Hours",
        "all_styles": "57&#189; Hours",
        "image": "https:\/\/howlongtobeat.com\/gameimages\/2412937-box_nnk_large.png"
    },
    {
        "title": "Nights of Azure",
        "main_story": "16&#189; Hours",
        "main_extra": "24&#189; Hours",
        "completionist": "50&#189; Hours",
        "all_styles": "22&#189; Hours",
        "image": "https:\/\/howlongtobeat.com\/gameimages\/35284_Nights_of_Azure.png"
    }
]
```
