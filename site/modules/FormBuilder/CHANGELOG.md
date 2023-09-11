# ProcessWire FormBuilder Changelog

Current versions of FormBuider require ProcessWire 3.x

-----------------------------------------------------------------

## Update #44 (0.4.4) - 2020/09/04

- Please note this version requires ProcessWire 3.0.164 or newer.
  To support the new search/filter/sort functions in the entries
  list, you must have MySQL 5.7 or newer. 

- This version makes significant improvements to ProcessWire’s 
  entries listing features and API. You can now find entries with 
  selector strings just like you can with pages in ProcessWire. 

- The entries screen for any form now gives you option to search
  and/or filter based on any field in the form. You can also 
  create multiple filters on top of one another, matching multiple
  fields or even multiple values for the same field. 
 
- You can dynamically select what columns appear in the entries
  list, and in what order.   

- You can now sort by any form field in the entries list by 
  clicking the column headings. Also supports reverse order. 

- The CSV export has been improved with options to export based
  on your filters/columns selection, or export all rows/columns.  

- CSV export now also has options for letting you specify what
  type of column headings to use and option to enable UTF-8 BOM.

- Numerous minor bug fixes and other improvements throughout.   

-----------------------------------------------------------------

## Update #40 (0.4.0) - 2019/10/10

- Added support for paginated forms. To use, install module 
  InputfieldFormBuilderPageBreak and create one or more fields that
  use “PageBreak (for FormBuilder)” as the type, which each instance
  represents the beginning of a pagination. See also the form 
  “Settings” tab for additional pagination settings once there
  is at least one PageBreak field in the form. 
  
- Added support for partial entries. These go alongside paginated  
  forms, enabling the user’s progress to be saved on a partial 
  entry in the database for each pagination. The benefit is that
  a form submission can be built (and viewed by the admin) in 
  stages, and an incomplete form submission can never be lost.
  A form with a partial entry also has a dedicated URL that can
  be bookmarked and returned to, even if a user’s session expires.
  To enable, your form must have one or more PageBreak fields,
  and you must select “Database” for entry storage on the “Settings”
  tab of the form. 
  
- Added support for “forms in forms”. To use, install module
  InputfieldFormBuilderForm. Create a form that you want to 
  embed within another (i.e. “mailing-address” or something 
  like that) and add one or more fields to it. Now edit the form
  where you want to embed it within and add field of type “Form 
  (for FormBuilder)”, click on the “Details” tab when editing the 
  field and select the form you want to embed. 

- Added support for click-and-drag adjustments to field widths.   
  To use when editing a form, click, hold and drag the percentage label 
  (i.e. “100%”) that appears on the right side of any field row
  in your form. Drag down or left to reduce the percentage, or drag
  up or right to increase it. The change is saved automatically when
  you release the mouse click. 
  
- Added support for row completion indicators when editing a form. 
  These appear as up and down carets on the right side of a field row,
  where the white down-pointing caret indicates start of a row, and 
  the black up-pointing arrow indicates the completion of the row
  (indicating widths total to 100%). If a row width does not total to
  100% then the color of the caret icon changes to red. 
  
- Added support for double-click to toggle “required” state of a field.  
  To use when editing a form, double-click the type label (i.e. “Text”)
  on the right side of any field row in your form. It will toggle and
  save the required state of the field, and will be indicated by the 
  presence of an asterisk to the left of the input type label.

- Major improvements to the “Basic” output framework. These are largely
  CSS adjustments to improve the visual output, but there are other
  improvements as well, such as the ability to configure the submit
  button color in the form configuration. 

- Add new toggle where you can specify that a form is exclusively
  for embedding within other forms. This is useful if you don't 
  want the form showing up in entries navigation, for example. 
  This can be found on the Settings tab of a form.  

- Add a new toggle to disable a form from being rendered or 
  processed. Similar to the toggle mentioned above, this enables
  you to basically disable a form, while still making it available
  for inclusion within another.   
  
- Major refactoring of FormBuilderProcessor, which is now divided
  into several different classes.   
  
- Improvements to the import features. It can now identify and import
  differences in field order, and it can now suggest fields that   
  might be removed. 

- Numerous other updates, optimizations and re-factorings.   
  
-----------------------------------------------------------------

## Update #39 (0.3.9) - 2019/05/31

- Add support for saving entries to Google Sheets spreadsheets. 
  This option can be found on the Actions tab of any form. To use
  it you must install the GoogleClientAPI module developed by 
  the same author as FormBuilder. More details appear when you 
  click the box to enable this action. 
  
- Add support for remembering completed fields in cookies. This 
  ensures that a partially completed form can be left and returned
  to without losing what’s been entered so far. You'll see the 
  option to enable this on the Settings tab of any form.   

-----------------------------------------------------------------

## Update #38 (0.3.8) - 2019/05/10

- Add support for importing fields and/or form properties into 
  existing forms, enabling you to essentially merge forms. The import
  tool provides checkboxes and diffs enabling you to select what 
  specific fields and/or properties you want to import. 
  
- Add support for new Stripe payment module. This module can be 
  downloaded from the FormBuilder support board download thread. 
  
- Add auto-responder "from" name and "reply-to" email address.   

- Framework updates to latest Bootstrap, Foundation and Uikit 3/2 
  versions. Remove Legacy and Admin frameworks, unless already in use.
  
- Add support for downloading form export (JSON) in addition to the
  existing selecdt and "copy" option. This option only appears if
  your PW core version is 3.0.132 or newer. 
  
- Add new "Use UTF-8 BOM in CSV?" module config setting for form
  entries CSV exports, which some versions of Excel require in 
  order to recognize the CSV as using the UTF-8 charset. 
  
- Refactor the FormBuilder module config screen to look better and
  organize all related settings into fieldsets.   
  
- Add support for direct modal edit links on the entries screen.   

- Added ability to module config to specify the default "from" email
  address to use for emails sent by FormBuilder. 

- Added ability to specify which WireMail module should be used for
  transactional email sent by FormBuilder (in the module config).  
  
- Schema change to DB so that entry "created" date is not updated
  automatically whenever the entry is updated.    
  
- Minor refactor to all FormBuilder classes in order to make them 
  all use the ProcessWire namespace. This means FormBuilder no longer
  needs to be compiled by PW 3.x FileCompiler and instead operates
  as a native PW 3.x module. 
  
- The "Basic" output framework has been redone with various 
  improvements. This framework is just a small CSS file (now SCSS), 
  suitable for expanding from for your own CSS styling of FormBuilder
  forms. 

-----------------------------------------------------------------

## Updates #35-37 

- Development versions without official releases

-----------------------------------------------------------------

## Update #34 (0.3.4) - 2018/06/08 

- New email files as attachments option. Now you can optionally 
  configure your forms to add user uploaded files as attachments 
  to the email that gets sent to the administrator. This option 
  is found under the Actions tab when editing a form, in the 
  "Send email to administrators" fieldset, field: "How to handle 
  uploaded files?" 

- Added support for automatically deleting form submissions (entries) 
  from the server, after a specific number of days. The option can 
  be found on the Actions tab when editing a form, in the "Save to 
  entries database" fieldset, field: "Automatically delete entries 
  after how many days?". Maintenance runs twice per day. 

- Multi-language options are now available for Select, Checkboxes, 
  Radios and AsmSelect Inputfields, as well as any others that extend 
  them. NOTE: Requires ProcessWire 3.0.105 or newer to use this.
  
- Improved drop-down menus in Setup > Forms, now lets you drill down 
  directly to form-specific entries or editor.   
  
- The main form list (and dropdown) now show when the last form entry 
  was received for each form.  
  
- Support for form-specific email-administrator.php or 
  email-autoresponder.php template files.   
  
- New "markdown" and "html" options for defining your success message 
  in the form editor.   
  
- New option to specify multiple auto-responder fields (fields 
  containing email address to send auto-responder to).   
  
- The email-administrator.php and email-autoresponder.php template 
  files now also receive a $formBuilderEmail variable which is an 
  instance of the FormBuilderEmail object.   
  
- Added ability to edit the <iframe> tag that FormBuilder uses for 
  embed methods A and B. It is editable in the FormBuilder module 
  configuration “Output” fieldset. In addition, this enables you 
  to do things like force it to always load forms from HTTPS, or 
  use URL without scheme/host if you prefer it.   

- The $forms->load($formName); now also accepts boolean true as 
  $formName, which will make it return all forms (in an array) 
  rather than just one.  
  
- Several new hooks have been added to the form rendering, processing 
  and saving events.   
  
- New README-HOOKS.txt file added which documents FormBuilder's 
  hooks and contains HOW-TO and REFERENCE sections. 

- Various improvements throughout to improve appearance and UI and 
  AdminThemeUikit. 

- Visual improvements to FormBuilder module configuration screen.   

-----------------------------------------------------------------

## Update #32 and #33 - Mid and Late 2017

- Various minor tweaks and bug fixes

-----------------------------------------------------------------

## Update #31 - 2017/04/07

- Numerous bug fixes and optimizations.
- Added Uikit 3 beta framework support.
- Added "resend" method for email form entries (both API and admin button).
- Continued updates to code documentation.
- Several incremental improvements throughout.
- Requires ProcessWire 2.7.2 or newer (PW 3.0.42+ recommended)

-----------------------------------------------------------------

## Update #30 - 2016/04/01

- Add new embed method D: Custom Embed + Custom Markup (major addition!)
- Add new "Basic" framework as our new recommended default.
- Change field editor to use modals by default. 
- Update "Preview" tab to always reload. 
- Update form editor to confirm before abandoning changes. 
- New redesigned field editor with tabs and other improvements.
- Several updates and improvements to Entries screen.
- Update entry view and edit actions to use modals. 
- Improvements and fixes to entry editor. 
- Various bug fixes and other optimizations. 
- Update version of included Uikit framework to latest.
- Addition of new "Basic" jQuery UI theme to accompany Basic framework.
- Code refactoring in several areas, especially ProcessFormBuilder.js
- Update code for comprehensive phpdoc documentation. 
- Requires ProcessWire 2.7.0 or newer and also supports PW 3.x. 

-----------------------------------------------------------------

## Update #25 - 2015/03/20

- Add support for output using CSS frameworks: Foundation, Uikit and Bootstrap
- Add support for Default admin and Reno admin themes/frameworks
- Add support for custom defined responsive breakpoint
- Make new API for embed method C, making it a lot simpler to use

-----------------------------------------------------------------

## Update #24 - 2014/10/01

- Various updates to take advantage of ProcessWire 2.5 features
- Add new external themes directory option: /site/templates/FormBuilder/themes/
- Fully convert Form Builder to use PDO (previous versions still used some mysqli)
- Add 'compare' option to entries exported as pages to compare existing pages w/entry.
- Various other minor bug fixes and additions
- This version of Form Builder requires ProcessWire 2.4 or newer

-----------------------------------------------------------------

## Update #23 - early 2014

- Several new hooks added to FormBuilderProcessor
- Add new themes: jmetro, aristo, delta
- Various minor bug fixes

-----------------------------------------------------------------

## Update #22 - 2013/06/05

- This version is designed to work with ProcessWire 2.3 dev (PDO) and newer.
  Note that previous versions of FormBuilder will not work with 2.3 dev (PDO).
- Bugfix to the auto-responder custom text which didn't work unless you had
  at least one `[field-name]` variable present. 

-----------------------------------------------------------------

## Update #21 - 2013/04/02

- Added multi-language support for field label, description and notes. 
- Added multi-language support for form success and error messages and auto responder text. 
- Autoresponder body text now configurable from form editor.
- Autoresponder body text accepts variables in `[brackets]`, example: `[first_name]`
- Transparent background fixes thanks to MadeMyDay.

-----------------------------------------------------------------

## Update #20 - 2012/02/05

- Various minor bugfixes and optimizations
- Add new checkbox on Settings tab enabling you to disable session tracking and
  CSRF protection. This is useful if you want to cache your forms with ProCache
  or if you want to send form submissions to a 3rd party script. 
- Optimizations and improvements to the 'plain2' theme

-----------------------------------------------------------------

## Update #19 - 2012/12/06

- Fix bug with file uploads that prevented them from working when the files field
  was placed in a Fieldset. Also made the mail() function recognize the $config
  variable: $config->phpMailAdditionalParameters, where you may specify additional
  parameters to FormBuilder's usage of PHP's mail() function, if necessary. This
  would be set from your /site/config.php. 

-----------------------------------------------------------------

## Update #18 - 2012/11/22

- Add support for form-level access control. To enable, check the Access Control box
  on your Modules > Form Builder module config screen. This update also installs a
  permission called form-builder-add, which is the permission you would assign to 
  roles you want to be allowed to add new forms. 

-----------------------------------------------------------------

## Update #17 - 2012/11/12

- Addition of File Inputfield, specific to use with Form Builder. Various other minor
  bugfixes and tweaks were made as well. 

-----------------------------------------------------------------

## Update #16 - 2012/10/10

- Add new option that lets the form be preset with values from GET variables. To enable
  check the box under the 'settings' tab of your form. Once you do that, any GET variables
  present that carry the same name as a form field will be populated to the form. This 
  works with all embed methods and FormBuilder takes care of delivering the data to the
  embed methods that use iframes.

-----------------------------------------------------------------

## Update #15 - 2012/10/05

- Add new auto-responder feature

-----------------------------------------------------------------

## Update #14 - 2012/10/03

- Add new form submission action: Save to ProcessWire Pages
- Add new 'Actions' and 'Output' tabs in the form admin screen
- Add new CSV delimiter option to the Form Builder config
- Various minor bug fixes 

-----------------------------------------------------------------

## Update #13 - 2012/09/23

- Add support for a 'notes' field that appears below the input. This is essentially the same 
  as the 'description' field, except that it appears below, rather than above, the input. 
  You'll see this 'notes' field used throughout ProcessWire already, so this just lets Form 
  Builder use this existing feature.

- Updated the 'Markup' inputfield (InputfieldMarkup) to be usable with Form Builder. To take 
  advantage of this, you'll have to grab the latest ProcessWire core (2.2.9). If you don't 
  have 'Markup' listed as an input type when creating a field in Form Builder, then go to the 
  module settings and add it to the list of allowed inputs.

-----------------------------------------------------------------

## Update #12 - 2012/09/20

- Correct issue with possible field name/form setting clashes (i.e. naming a field 'honeypot')

-----------------------------------------------------------------

## Update #11 - 2012/09/20

- Correct issues with single Checkbox fields.
- Updated required ProcessWire version to 2.2.8
- Removed redundant error messages from the top of a failed form submission.

-----------------------------------------------------------------

## Update #10 - 2012/09/18
	
- First release of Form Builder


