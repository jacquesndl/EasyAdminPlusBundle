# Additional templates
**EasyAdminPlus** is packaged with additional templates for [vich/uploader-bundle](https://github.com/dustin10/VichUploaderBundle) and [greg0ire/enum](https://github.com/greg0ire/enum).

## vich/uploader-bundle
```yaml
fields:
    # ...
    - { property: 'image.name', template: '@JacquesndlEasyAdminPlus/templates/vich_uploader_image.html.twig', propertyFile: 'imageFile' }
    # ...
```

## greg0ire/enum
```yaml
fields:
    # ...
    - { property: 'type', template: '@JacquesndlEasyAdminPlus/templates/greg0ire_enum.html.twig', enumClass: 'App\Enum\TypeChoice', enumTranslationDomain: 'messages' }
    # ...
```

Previous chapter: [Chapter 1 - Authentication](chapter-1.md)
