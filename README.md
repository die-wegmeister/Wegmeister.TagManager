# Wegmeister.TagManager

> [!WARNING]
> This package does no longer receive any update and should no longer be used. Prefer using Nodes as it is easier to extend them.

## Installation

Run the following command to add the package to your Neos-installation:

    composer require wegmeister/tagmanager

## How to use

Add one of the following Mixins to the supertypes of your NodeTypes definition:

    'Wegmeister.TagManager:TagMixin' or
    'Wegmeister.TagManager:TagsMixin'

If you only want to make specific groups available, add the following filter to your NodeType definition:

```yaml
    properties:
      tag: # if u use the TagsMixin, this should be 'tags'
        ui:
        inspector:
          editorOptions:
            dataSourceAdditionalData:
              groups: ['Name-of-Group-1', 'Name-of-Group-2']
```
