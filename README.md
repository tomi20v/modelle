# modelle

```php
class MyModel extends Modelle {
    const MODELLE_DEF = [
        'anyField' => [
            'getAs' => '<type>',
            'notNull' => true,	
            'default' => '...',
        ],
        'anyArrayField' => [
            'getAs' => ['<type>'],
            'notNull' => true,	
            'default' => '...',
        ],
    ];
}
```

```
anyField - name of field to handle\
default - return this is value is not set (or is null) NOTE: default value will be still casted if getAs is set\
getAs - force returning this type. If a classname is given, that class should extend Modelle (to keep wrapping)\
notNull - used with getAs. Default is false, and null will be returned as null regardless of getAs value. When 
	isNull=true any missing or null value will be cast as per getAs
```

getAs types:
- bool
- int
- float
- string
- <any classname>
- ['<anyScalarType'>]
- [<anyClassname>]

definition shorthand: 
each field can be defined by just one string like "<getAs>|<notNull>|<default>", eg.
- "int|notNull|42"
- "[int]|notNull"
- "int"


@todo:
- find a better way to autoload test abstracts and testers
- add enum type
- add ref (eg. get existing 'someRelationId' field as 'some_relation_id' for compatibility)
- setAs property, would default to getAs
- implement notNull => default and notNull => next where second would serve as an auto increment field. might be enough 
	just to set it on push as it's pretty much the only way we can add a new object to a collection 
