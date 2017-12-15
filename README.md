# org.civicrmews.membershiprecords

![Screenshot](/images/membershiprecords-extension.png)

This extension will record periods/terms when a membership its created or renewed.
Also will show a link to the contribution if there was any payment.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v5.4+
* CiviCRM v4.7

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl org.civicrmews.membershiprecords@https://github.com/elennio/org.civicrmews.membershiprecords/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/elennio/org.civicrmews.membershiprecords.git
cv en membershiprecords
```

## Usage

When installed go to renew a membership or start creating one...
Then to see the membership records just select the contact view and see at the bottom, if there is any record you will be able to see it, 2 links will apear 1 for the Membership and if any payment registered the contribution link will be there too. 

## Known Issues

No issues yet.
