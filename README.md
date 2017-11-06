# modelle

```php
class MyModel extends Model {
    const MODELLE_DEF = [
        'anyField' => [
            'default' => '...',
            'getAs' => '<type>',
            'notNull' => true,	
        ],
    ];
}
```

```
anyField - name of field to handle\
default - return this is value is not set (or is null) NOTE: default value will be still casted if getAs is set\
getAs - force returning this type. If a classname is given, that class should extend Modelle (to keep wrapping)\
notNull - used with getAs. Default is false, and null will be returned as null regardless of getAs value. When isNull=true any missing or null value will be cast as per getAs
```

getAs types:
- bool
- int
- float
- string
- {any class name}


@todo:
- getAs = array (must be able to specify element class)
- find a better way to autoload test abstracts and testers
