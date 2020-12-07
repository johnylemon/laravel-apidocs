## Problems with defining apidocs within annotations

- **uri have to be typed within annotation**. This makes first duplicating code problem. Imagine api change (eg. wrapping huge amount of endpoint with prefix) will force you to update large number of annotations just to be sure that route uri definition matches annotation uri definition.

- **Weird syntax** and lack of documentation

- **Annotations takes huge amount of space** in files making your controllers unreadable or requires creating *one-action* controllers, just to keep file size in some rational boundaries

- **No information about other required tags**. When using some of them that information will be displayed only as error during apidocs generation process. Eg: param of `array` type requires `Items` tag

- **Hard to create complex payload definitions**

- **Duplicating payload definitions, responses and examples** within every route annotation, making apidocs hard to maintain on even small api change.

- **`refs`** included in some tags, designed to avoid problems listed above, **does not say where its definition is placed**. And does not solve problem of duplicated "code" especially within parameter definitions.
