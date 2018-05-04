# PhpBB Extension - marttiphpbb Extra Style

[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2470326)

## Requirements

phpBB 3.2+ PHP 7+

## Features

With this extension you define one forum as the "" for obsolete topics.
In the " forum" the original forum is shown below the title of each topic.
Two moderator actions are provided "" and "Restore". They depend on the same permission as "Move"(topics).
Note that you still have to set yourself the appropriate permissions for the "Extra Style" and give it a proper name (suggestion: ""). Normal users should not be able to post in there.

## Quick Install

You can install this on the latest release of phpBB 3.2 by following the steps below:

* Create `marttiphpbb/extrastyle` in the `ext` directory.
* Download and unpack the repository into `ext/marttiphpbb/extrastyle`
* Enable `Extra Style` in the ACP at `Customise -> Manage extensions`.
* You can start editing the Extra Style in the Forum ACP for each Forum.

## Uninstall

* Disable `Extra Style` in the ACP at `Customise -> Extension Management -> Extensions`.
* To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/extrastyle` directory.

## Support

* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-extrastyle/issues).

## License

[GPL-2.0](license.txt)

## Screenshots

### d Topic

![d Topic](doc/d_topic.png)

### Extra Style

![Extra Style](doc/_forum.png)

### Confirm 

![Confirm ](doc/confirm_.png)

### Confirm Restore

![Confirm Restore](doc/confirm_restore.png)

### MCP Forum

![MCP Forum](doc/mcp_forum.png)

### MCP Topic

![MCP Topic](doc/mcp_topic.png)

### Quickmod

![Quickmod](doc/quickmod.png)

### ACP

![ACP](doc/acp.png)
