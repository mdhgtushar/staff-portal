-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2023 at 07:30 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pw_staff_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `caches`
--

CREATE TABLE `caches` (
  `name` varchar(250) NOT NULL,
  `data` mediumtext NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `caches`
--

INSERT INTO `caches` (`name`, `data`, `expires`) VALUES
('Modules.wire/modules/', 'AdminTheme/AdminThemeDefault/AdminThemeDefault.module\nAdminTheme/AdminThemeReno/AdminThemeReno.module\nAdminTheme/AdminThemeUikit/AdminThemeUikit.module\nFieldtype/FieldtypeCache.module\nFieldtype/FieldtypeCheckbox.module\nFieldtype/FieldtypeComments/CommentFilterAkismet.module\nFieldtype/FieldtypeComments/FieldtypeComments.module\nFieldtype/FieldtypeComments/InputfieldCommentsAdmin.module\nFieldtype/FieldtypeDatetime.module\nFieldtype/FieldtypeDecimal.module\nFieldtype/FieldtypeEmail.module\nFieldtype/FieldtypeFieldsetClose.module\nFieldtype/FieldtypeFieldsetOpen.module\nFieldtype/FieldtypeFieldsetTabOpen.module\nFieldtype/FieldtypeFile/FieldtypeFile.module\nFieldtype/FieldtypeFloat.module\nFieldtype/FieldtypeImage/FieldtypeImage.module\nFieldtype/FieldtypeInteger.module\nFieldtype/FieldtypeModule.module\nFieldtype/FieldtypeOptions/FieldtypeOptions.module\nFieldtype/FieldtypePage.module\nFieldtype/FieldtypePageTable.module\nFieldtype/FieldtypePageTitle.module\nFieldtype/FieldtypePassword.module\nFieldtype/FieldtypeRepeater/FieldtypeFieldsetPage.module\nFieldtype/FieldtypeRepeater/FieldtypeRepeater.module\nFieldtype/FieldtypeRepeater/InputfieldRepeater.module\nFieldtype/FieldtypeSelector.module\nFieldtype/FieldtypeText.module\nFieldtype/FieldtypeTextarea.module\nFieldtype/FieldtypeToggle.module\nFieldtype/FieldtypeURL.module\nFileCompilerTags.module\nImage/ImageSizerEngineAnimatedGif/ImageSizerEngineAnimatedGif.module\nImage/ImageSizerEngineIMagick/ImageSizerEngineIMagick.module\nInputfield/InputfieldAsmSelect/InputfieldAsmSelect.module\nInputfield/InputfieldButton.module\nInputfield/InputfieldCheckbox/InputfieldCheckbox.module\nInputfield/InputfieldCheckboxes/InputfieldCheckboxes.module\nInputfield/InputfieldCKEditor/InputfieldCKEditor.module\nInputfield/InputfieldDatetime/InputfieldDatetime.module\nInputfield/InputfieldEmail.module\nInputfield/InputfieldFieldset.module\nInputfield/InputfieldFile/InputfieldFile.module\nInputfield/InputfieldFloat.module\nInputfield/InputfieldForm.module\nInputfield/InputfieldHidden.module\nInputfield/InputfieldIcon/InputfieldIcon.module\nInputfield/InputfieldImage/InputfieldImage.module\nInputfield/InputfieldInteger.module\nInputfield/InputfieldMarkup.module\nInputfield/InputfieldName.module\nInputfield/InputfieldPage/InputfieldPage.module\nInputfield/InputfieldPageAutocomplete/InputfieldPageAutocomplete.module\nInputfield/InputfieldPageListSelect/InputfieldPageListSelect.module\nInputfield/InputfieldPageListSelect/InputfieldPageListSelectMultiple.module\nInputfield/InputfieldPageName/InputfieldPageName.module\nInputfield/InputfieldPageTable/InputfieldPageTable.module\nInputfield/InputfieldPageTitle/InputfieldPageTitle.module\nInputfield/InputfieldPassword/InputfieldPassword.module\nInputfield/InputfieldRadios/InputfieldRadios.module\nInputfield/InputfieldSelect.module\nInputfield/InputfieldSelectMultiple.module\nInputfield/InputfieldSelector/InputfieldSelector.module\nInputfield/InputfieldSubmit/InputfieldSubmit.module\nInputfield/InputfieldText/InputfieldText.module\nInputfield/InputfieldTextarea.module\nInputfield/InputfieldTextTags/InputfieldTextTags.module\nInputfield/InputfieldTinyMCE/InputfieldTinyMCE.module.php\nInputfield/InputfieldToggle/InputfieldToggle.module\nInputfield/InputfieldURL.module\nJquery/JqueryCore/JqueryCore.module\nJquery/JqueryMagnific/JqueryMagnific.module\nJquery/JqueryTableSorter/JqueryTableSorter.module\nJquery/JqueryUI/JqueryUI.module\nJquery/JqueryWireTabs/JqueryWireTabs.module\nLanguageSupport/FieldtypePageTitleLanguage.module\nLanguageSupport/FieldtypeTextareaLanguage.module\nLanguageSupport/FieldtypeTextLanguage.module\nLanguageSupport/LanguageSupport.module\nLanguageSupport/LanguageSupportFields.module\nLanguageSupport/LanguageSupportPageNames.module\nLanguageSupport/LanguageTabs.module\nLanguageSupport/ProcessLanguage.module\nLanguageSupport/ProcessLanguageTranslator.module\nLazyCron.module\nMarkup/MarkupAdminDataTable/MarkupAdminDataTable.module\nMarkup/MarkupCache.module\nMarkup/MarkupHTMLPurifier/MarkupHTMLPurifier.module\nMarkup/MarkupPageArray.module\nMarkup/MarkupPageFields.module\nMarkup/MarkupPagerNav/MarkupPagerNav.module\nMarkup/MarkupRSS.module\nPage/PageFrontEdit/PageFrontEdit.module\nPagePathHistory.module\nPagePaths.module\nPagePermissions.module\nPageRender.module\nProcess/ProcessCommentsManager/ProcessCommentsManager.module\nProcess/ProcessField/ProcessField.module\nProcess/ProcessForgotPassword/ProcessForgotPassword.module\nProcess/ProcessHome.module\nProcess/ProcessList.module\nProcess/ProcessLogger/ProcessLogger.module\nProcess/ProcessLogin/ProcessLogin.module\nProcess/ProcessModule/ProcessModule.module\nProcess/ProcessPageAdd/ProcessPageAdd.module\nProcess/ProcessPageClone.module\nProcess/ProcessPageEdit/ProcessPageEdit.module\nProcess/ProcessPageEditImageSelect/ProcessPageEditImageSelect.module\nProcess/ProcessPageEditLink/ProcessPageEditLink.module\nProcess/ProcessPageList/ProcessPageList.module\nProcess/ProcessPageLister/ProcessPageLister.module\nProcess/ProcessPageSearch/ProcessPageSearch.module\nProcess/ProcessPagesExportImport/ProcessPagesExportImport.module\nProcess/ProcessPageSort.module\nProcess/ProcessPageTrash.module\nProcess/ProcessPageType/ProcessPageType.module\nProcess/ProcessPageView.module\nProcess/ProcessPermission/ProcessPermission.module\nProcess/ProcessProfile/ProcessProfile.module\nProcess/ProcessRecentPages/ProcessRecentPages.module\nProcess/ProcessRole/ProcessRole.module\nProcess/ProcessTemplate/ProcessTemplate.module\nProcess/ProcessUser/ProcessUser.module\nSession/SessionHandlerDB/ProcessSessionDB.module\nSession/SessionHandlerDB/SessionHandlerDB.module\nSession/SessionLoginThrottle/SessionLoginThrottle.module\nSystem/SystemNotifications/FieldtypeNotifications.module\nSystem/SystemNotifications/SystemNotifications.module\nSystem/SystemUpdater/SystemUpdater.module\nTextformatter/TextformatterEntities.module\nTextformatter/TextformatterMarkdownExtra/TextformatterMarkdownExtra.module\nTextformatter/TextformatterNewlineBR.module\nTextformatter/TextformatterNewlineUL.module\nTextformatter/TextformatterPstripper.module\nTextformatter/TextformatterSmartypants/TextformatterSmartypants.module\nTextformatter/TextformatterStripTags.module', '2010-04-08 03:10:01'),
('Modules.site/modules/', 'FormBuilder/FormBuilder.module\nFormBuilder/InputfieldFormBuilderFile.module\nFormBuilder/InputfieldFormBuilderForm.module\nFormBuilder/InputfieldFormBuilderPageBreak.module\nFormBuilder/ProcessFormBuilder.module\nFrontendForms/FrontendForms.module\nLoginRegister/LoginRegister.module', '2010-04-08 03:10:01'),
('ModulesVerbose.info', '{\"148\":{\"summary\":\"Minimal admin theme that supports all ProcessWire features.\",\"core\":true,\"versionStr\":\"0.1.4\"},\"166\":{\"summary\":\"Uikit v3 admin theme\",\"core\":true,\"versionStr\":\"0.3.3\"},\"97\":{\"summary\":\"This Fieldtype stores an ON\\/OFF toggle via a single checkbox. The ON value is 1 and OFF value is 0.\",\"core\":true,\"versionStr\":\"1.0.1\"},\"28\":{\"summary\":\"Field that stores a date and optionally time\",\"core\":true,\"versionStr\":\"1.0.5\"},\"29\":{\"summary\":\"Field that stores an e-mail address\",\"core\":true,\"versionStr\":\"1.0.1\"},\"106\":{\"summary\":\"Close a fieldset opened by FieldsetOpen. \",\"core\":true,\"versionStr\":\"1.0.0\"},\"105\":{\"summary\":\"Open a fieldset to group fields. Should be followed by a Fieldset (Close) after one or more fields.\",\"core\":true,\"versionStr\":\"1.0.1\"},\"107\":{\"summary\":\"Open a fieldset to group fields. Same as Fieldset (Open) except that it displays in a tab instead.\",\"core\":true,\"versionStr\":\"1.0.0\"},\"6\":{\"summary\":\"Field that stores one or more files\",\"core\":true,\"versionStr\":\"1.0.7\"},\"89\":{\"summary\":\"Field that stores a floating point number\",\"core\":true,\"versionStr\":\"1.0.7\"},\"57\":{\"summary\":\"Field that stores one or more GIF, JPG, or PNG images\",\"core\":true,\"versionStr\":\"1.0.2\"},\"84\":{\"summary\":\"Field that stores an integer\",\"core\":true,\"versionStr\":\"1.0.2\"},\"27\":{\"summary\":\"Field that stores a reference to another module\",\"core\":true,\"versionStr\":\"1.0.2\"},\"173\":{\"summary\":\"Field that stores single and multi select options.\",\"core\":true,\"versionStr\":\"0.0.2\"},\"4\":{\"summary\":\"Field that stores one or more references to ProcessWire pages\",\"core\":true,\"versionStr\":\"1.0.7\"},\"111\":{\"summary\":\"Field that stores a page title\",\"core\":true,\"versionStr\":\"1.0.0\"},\"133\":{\"summary\":\"Field that stores a hashed and salted password\",\"core\":true,\"versionStr\":\"1.0.1\"},\"174\":{\"summary\":\"Build a page finding selector visually.\",\"author\":\"Avoine + ProcessWire\",\"core\":true,\"versionStr\":\"0.1.3\"},\"3\":{\"summary\":\"Field that stores a single line of text\",\"core\":true,\"versionStr\":\"1.0.2\"},\"1\":{\"summary\":\"Field that stores multiple lines of text\",\"core\":true,\"versionStr\":\"1.0.7\"},\"175\":{\"summary\":\"Configurable yes\\/no, on\\/off toggle alternative to a checkbox, plus optional \\u201cother\\u201d option.\",\"core\":true,\"versionStr\":\"0.0.1\"},\"135\":{\"summary\":\"Field that stores a URL\",\"core\":true,\"versionStr\":\"1.0.1\"},\"25\":{\"summary\":\"Multiple selection, progressive enhancement to select multiple\",\"core\":true,\"versionStr\":\"2.0.3\"},\"131\":{\"summary\":\"Form button element that you can optionally pass an href attribute to.\",\"core\":true,\"versionStr\":\"1.0.0\"},\"37\":{\"summary\":\"Single checkbox toggle\",\"core\":true,\"versionStr\":\"1.0.6\"},\"38\":{\"summary\":\"Multiple checkbox toggles\",\"core\":true,\"versionStr\":\"1.0.8\"},\"94\":{\"summary\":\"Inputfield that accepts date and optionally time\",\"core\":true,\"versionStr\":\"1.0.7\"},\"80\":{\"summary\":\"E-Mail address in valid format\",\"core\":true,\"versionStr\":\"1.0.2\"},\"78\":{\"summary\":\"Groups one or more fields together in a container\",\"core\":true,\"versionStr\":\"1.0.1\"},\"55\":{\"summary\":\"One or more file uploads (sortable)\",\"core\":true,\"versionStr\":\"1.2.8\"},\"90\":{\"summary\":\"Floating point number with precision\",\"core\":true,\"versionStr\":\"1.0.5\"},\"30\":{\"summary\":\"Contains one or more fields in a form\",\"core\":true,\"versionStr\":\"1.0.7\"},\"40\":{\"summary\":\"Hidden value in a form\",\"core\":true,\"versionStr\":\"1.0.1\"},\"168\":{\"summary\":\"Select an icon\",\"core\":true,\"versionStr\":\"0.0.3\"},\"56\":{\"summary\":\"One or more image uploads (sortable)\",\"core\":true,\"versionStr\":\"1.2.6\"},\"85\":{\"summary\":\"Integer (positive or negative)\",\"core\":true,\"versionStr\":\"1.0.5\"},\"79\":{\"summary\":\"Contains any other markup and optionally child Inputfields\",\"core\":true,\"versionStr\":\"1.0.2\"},\"41\":{\"summary\":\"Text input validated as a ProcessWire name field\",\"core\":true,\"versionStr\":\"1.0.0\"},\"60\":{\"summary\":\"Select one or more pages\",\"core\":true,\"versionStr\":\"1.0.8\"},\"170\":{\"summary\":\"Multiple Page selection using auto completion and sorting capability. Intended for use as an input field for Page reference fields.\",\"core\":true,\"versionStr\":\"1.1.3\"},\"15\":{\"summary\":\"Selection of a single page from a ProcessWire page tree list\",\"core\":true,\"versionStr\":\"1.0.1\"},\"137\":{\"summary\":\"Selection of multiple pages from a ProcessWire page tree list\",\"core\":true,\"versionStr\":\"1.0.3\"},\"86\":{\"summary\":\"Text input validated as a ProcessWire Page name field\",\"core\":true,\"versionStr\":\"1.0.6\"},\"112\":{\"summary\":\"Handles input of Page Title and auto-generation of Page Name (when name is blank)\",\"core\":true,\"versionStr\":\"1.0.2\"},\"122\":{\"summary\":\"Password input with confirmation field that doesn&#039;t ever echo the input back.\",\"core\":true,\"versionStr\":\"1.0.2\"},\"39\":{\"summary\":\"Radio buttons for selection of a single item\",\"core\":true,\"versionStr\":\"1.0.6\"},\"36\":{\"summary\":\"Selection of a single value from a select pulldown\",\"core\":true,\"versionStr\":\"1.0.2\"},\"43\":{\"summary\":\"Select multiple items from a list\",\"core\":true,\"versionStr\":\"1.0.1\"},\"149\":{\"summary\":\"Build a page finding selector visually.\",\"author\":\"Avoine + ProcessWire\",\"core\":true,\"versionStr\":\"0.2.8\"},\"32\":{\"summary\":\"Form submit button\",\"core\":true,\"versionStr\":\"1.0.3\"},\"34\":{\"summary\":\"Single line of text\",\"core\":true,\"versionStr\":\"1.0.6\"},\"35\":{\"summary\":\"Multiple lines of text\",\"core\":true,\"versionStr\":\"1.0.3\"},\"169\":{\"summary\":\"Enables input of user entered tags or selection of predefined tags.\",\"core\":true,\"versionStr\":\"0.0.5\"},\"155\":{\"summary\":\"TinyMCE rich text editor version 6.4.1.\",\"core\":true,\"versionStr\":\"6.1.5\"},\"172\":{\"summary\":\"A toggle providing similar input capability to a checkbox but much more configurable.\",\"core\":true,\"versionStr\":\"0.0.1\"},\"108\":{\"summary\":\"URL in valid format\",\"core\":true,\"versionStr\":\"1.0.3\"},\"116\":{\"summary\":\"jQuery Core as required by ProcessWire Admin and plugins\",\"href\":\"https:\\/\\/jquery.com\",\"core\":true,\"versionStr\":\"1.12.4\"},\"151\":{\"summary\":\"Provides lightbox capability for image galleries. Replacement for FancyBox. Uses Magnific Popup by @dimsemenov.\",\"href\":\"https:\\/\\/github.com\\/dimsemenov\\/Magnific-Popup\\/\",\"core\":true,\"versionStr\":\"1.1.0\"},\"103\":{\"summary\":\"Provides a jQuery plugin for sorting tables.\",\"href\":\"https:\\/\\/mottie.github.io\\/tablesorter\\/\",\"core\":true,\"versionStr\":\"2.31.3\"},\"117\":{\"summary\":\"jQuery UI as required by ProcessWire and plugins\",\"href\":\"https:\\/\\/ui.jquery.com\",\"core\":true,\"versionStr\":\"1.10.4\"},\"45\":{\"summary\":\"Provides a jQuery plugin for generating tabs in ProcessWire.\",\"core\":true,\"versionStr\":\"1.1.0\"},\"67\":{\"summary\":\"Generates markup for data tables used by ProcessWire admin\",\"core\":true,\"versionStr\":\"1.0.7\"},\"156\":{\"summary\":\"Front-end to the HTML Purifier library.\",\"core\":true,\"versionStr\":\"4.9.7\"},\"113\":{\"summary\":\"Adds renderPager() method to all PaginatedArray types, for easy pagination output. Plus a render() method to PageArray instances.\",\"core\":true,\"versionStr\":\"1.0.0\"},\"98\":{\"summary\":\"Generates markup for pagination navigation\",\"core\":true,\"versionStr\":\"1.0.5\"},\"176\":{\"summary\":\"Enables front-end editing of page fields.\",\"author\":\"Ryan Cramer\",\"core\":true,\"versionStr\":\"0.0.6\",\"permissions\":{\"page-edit-front\":\"Use the front-end page editor\"},\"license\":\"MPL 2.0\"},\"114\":{\"summary\":\"Adds various permission methods to Page objects that are used by Process modules.\",\"core\":true,\"versionStr\":\"1.0.5\"},\"115\":{\"summary\":\"Adds a render method to Page and caches page output.\",\"core\":true,\"versionStr\":\"1.0.5\"},\"48\":{\"summary\":\"Edit individual fields that hold page data\",\"core\":true,\"versionStr\":\"1.1.4\",\"searchable\":\"fields\"},\"178\":{\"summary\":\"Provides password reset\\/email capability for the Login process.\",\"core\":true,\"versionStr\":\"1.0.4\"},\"87\":{\"summary\":\"Acts as a placeholder Process for the admin root. Ensures proper flow control after login.\",\"core\":true,\"versionStr\":\"1.0.1\"},\"76\":{\"summary\":\"Lists the Process assigned to each child page of the current\",\"core\":true,\"versionStr\":\"1.0.1\"},\"167\":{\"summary\":\"View and manage system logs.\",\"author\":\"Ryan Cramer\",\"core\":true,\"versionStr\":\"0.0.2\",\"permissions\":{\"logs-view\":\"Can view system logs\",\"logs-edit\":\"Can manage system logs\"},\"page\":{\"name\":\"logs\",\"parent\":\"setup\",\"title\":\"Logs\"}},\"10\":{\"summary\":\"Login to ProcessWire\",\"core\":true,\"versionStr\":\"1.0.9\"},\"50\":{\"summary\":\"List, edit or install\\/uninstall modules\",\"core\":true,\"versionStr\":\"1.2.0\"},\"17\":{\"summary\":\"Add a new page\",\"core\":true,\"versionStr\":\"1.0.9\"},\"7\":{\"summary\":\"Edit a Page\",\"core\":true,\"versionStr\":\"1.1.2\"},\"129\":{\"summary\":\"Provides image manipulation functions for image fields and rich text editors.\",\"core\":true,\"versionStr\":\"1.2.1\"},\"121\":{\"summary\":\"Provides a link capability as used by some Fieldtype modules (like rich text editors).\",\"core\":true,\"versionStr\":\"1.1.2\"},\"12\":{\"summary\":\"List pages in a hierarchical tree structure\",\"core\":true,\"versionStr\":\"1.2.4\"},\"150\":{\"summary\":\"Admin tool for finding and listing pages by any property.\",\"author\":\"Ryan Cramer\",\"core\":true,\"versionStr\":\"0.2.6\",\"permissions\":{\"page-lister\":\"Use Page Lister\"}},\"104\":{\"summary\":\"Provides a page search engine for admin use.\",\"core\":true,\"versionStr\":\"1.0.8\"},\"14\":{\"summary\":\"Handles page sorting and moving for PageList\",\"core\":true,\"versionStr\":\"1.0.0\"},\"109\":{\"summary\":\"Handles emptying of Page trash\",\"core\":true,\"versionStr\":\"1.0.3\"},\"134\":{\"summary\":\"List, Edit and Add pages of a specific type\",\"core\":true,\"versionStr\":\"1.0.1\"},\"83\":{\"summary\":\"All page views are routed through this Process\",\"core\":true,\"versionStr\":\"1.0.6\"},\"136\":{\"summary\":\"Manage system permissions\",\"core\":true,\"versionStr\":\"1.0.1\"},\"138\":{\"summary\":\"Enables user to change their password, email address and other settings that you define.\",\"core\":true,\"versionStr\":\"1.0.5\"},\"165\":{\"summary\":\"Shows a list of recently edited pages in your admin.\",\"author\":\"Ryan Cramer\",\"href\":\"http:\\/\\/modules.processwire.com\\/\",\"core\":true,\"versionStr\":\"0.0.2\",\"permissions\":{\"page-edit-recent\":\"Can see recently edited pages\"},\"page\":{\"name\":\"recent-pages\",\"parent\":\"page\",\"title\":\"Recent\"}},\"68\":{\"summary\":\"Manage user roles and what permissions are attached\",\"core\":true,\"versionStr\":\"1.0.4\"},\"47\":{\"summary\":\"List and edit the templates that control page output\",\"core\":true,\"versionStr\":\"1.1.4\",\"searchable\":\"templates\"},\"66\":{\"summary\":\"Manage system users\",\"core\":true,\"versionStr\":\"1.0.7\",\"searchable\":\"users\"},\"125\":{\"summary\":\"Throttles login attempts to help prevent dictionary attacks.\",\"core\":true,\"versionStr\":\"1.0.3\"},\"139\":{\"summary\":\"Manages system versions and upgrades.\",\"core\":true,\"versionStr\":\"0.2.0\"},\"61\":{\"summary\":\"Entity encode ampersands, quotes (single and double) and greater-than\\/less-than signs using htmlspecialchars(str, ENT_QUOTES). It is recommended that you use this on all text\\/textarea fields except those using a rich text editor or a markup language like Markdown.\",\"core\":true,\"versionStr\":\"1.0.0\"},\"171\":{\"summary\":\"Markdown\\/Parsedown extra lightweight markup language by Emanuil Rusev. Based on Markdown by John Gruber.\",\"core\":true,\"versionStr\":\"1.8.0\"},\"177\":{\"summary\":\"Login or register for an account in ProcessWire\",\"versionStr\":\"0.0.2\"},\"179\":{\"summary\":\"Create or edit forms and manage submitted entries.\",\"versionStr\":\"0.4.6\"},\"180\":{\"summary\":\"Create or edit forms and manage submitted entries.\",\"versionStr\":\"0.4.6\"},\"181\":{\"summary\":\"Form Builder file upload input (alpha test)\",\"versionStr\":\"0.0.2\"}}', '2010-04-08 03:10:01'),
('ModulesUninstalled.info', '{\"AdminThemeReno\":{\"name\":\"AdminThemeReno\",\"title\":\"Reno\",\"version\":17,\"versionStr\":\"0.1.7\",\"author\":\"Tom Reno (Renobird)\",\"summary\":\"Admin theme for ProcessWire 2.5+ by Tom Reno (Renobird)\",\"requiresVersions\":{\"AdminThemeDefault\":[\">=\",0]},\"autoload\":\"template=admin\",\"created\":1692316722,\"installed\":false,\"configurable\":3,\"core\":true},\"AdminThemeUikit\":{\"name\":\"AdminThemeUikit\",\"title\":\"Uikit\",\"version\":33,\"versionStr\":\"0.3.3\",\"summary\":\"Uikit v3 admin theme\",\"autoload\":\"template=admin\",\"created\":1692305922,\"installed\":false,\"configurable\":4,\"core\":true},\"FieldtypeCache\":{\"name\":\"FieldtypeCache\",\"title\":\"Cache\",\"version\":102,\"versionStr\":\"1.0.2\",\"summary\":\"Caches the values of other fields for fewer runtime queries. Can also be used to combine multiple text fields and have them all be searchable under the cached field name.\",\"created\":1692316740,\"installed\":false,\"core\":true},\"CommentFilterAkismet\":{\"name\":\"CommentFilterAkismet\",\"title\":\"Comment Filter: Akismet\",\"version\":200,\"versionStr\":\"2.0.0\",\"summary\":\"Uses the Akismet service to identify comment spam. Module plugin for the Comments Fieldtype.\",\"requiresVersions\":{\"FieldtypeComments\":[\">=\",0]},\"created\":1692316742,\"installed\":false,\"configurable\":3,\"core\":true},\"FieldtypeComments\":{\"name\":\"FieldtypeComments\",\"title\":\"Comments\",\"version\":110,\"versionStr\":\"1.1.0\",\"summary\":\"Field that stores user posted comments for a single Page\",\"installs\":[\"InputfieldCommentsAdmin\"],\"created\":1692316742,\"installed\":false,\"core\":true},\"InputfieldCommentsAdmin\":{\"name\":\"InputfieldCommentsAdmin\",\"title\":\"Comments Admin\",\"version\":104,\"versionStr\":\"1.0.4\",\"summary\":\"Provides an administrative interface for working with comments\",\"requiresVersions\":{\"FieldtypeComments\":[\">=\",0]},\"created\":1692316742,\"installed\":false,\"core\":true},\"FieldtypeDecimal\":{\"name\":\"FieldtypeDecimal\",\"title\":\"Decimal\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Field that stores a decimal number\",\"created\":1692316740,\"installed\":false,\"core\":true},\"FieldtypeOptions\":{\"name\":\"FieldtypeOptions\",\"title\":\"Select Options\",\"version\":2,\"versionStr\":\"0.0.2\",\"summary\":\"Field that stores single and multi select options.\",\"created\":1692305941,\"installed\":false,\"core\":true},\"FieldtypePageTable\":{\"name\":\"FieldtypePageTable\",\"title\":\"ProFields: Page Table\",\"version\":8,\"versionStr\":\"0.0.8\",\"summary\":\"A fieldtype containing a group of editable pages.\",\"installs\":[\"InputfieldPageTable\"],\"autoload\":true,\"created\":1692316740,\"installed\":false,\"core\":true},\"FieldtypeFieldsetPage\":{\"name\":\"FieldtypeFieldsetPage\",\"title\":\"Fieldset (Page)\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Fieldset with fields isolated to separate namespace (page), enabling re-use of fields.\",\"requiresVersions\":{\"FieldtypeRepeater\":[\">=\",0]},\"autoload\":true,\"created\":1692316742,\"installed\":false,\"configurable\":3,\"core\":true},\"FieldtypeRepeater\":{\"name\":\"FieldtypeRepeater\",\"title\":\"Repeater\",\"version\":112,\"versionStr\":\"1.1.2\",\"summary\":\"Maintains a collection of fields that are repeated for any number of times.\",\"installs\":[\"InputfieldRepeater\"],\"autoload\":true,\"created\":1692316742,\"installed\":false,\"configurable\":3,\"core\":true},\"InputfieldRepeater\":{\"name\":\"InputfieldRepeater\",\"title\":\"Repeater\",\"version\":111,\"versionStr\":\"1.1.1\",\"summary\":\"Repeats fields from another template. Provides the input for FieldtypeRepeater.\",\"requiresVersions\":{\"FieldtypeRepeater\":[\">=\",0]},\"created\":1692316742,\"installed\":false,\"core\":true},\"FieldtypeSelector\":{\"name\":\"FieldtypeSelector\",\"title\":\"Selector\",\"version\":13,\"versionStr\":\"0.1.3\",\"author\":\"Avoine + ProcessWire\",\"summary\":\"Build a page finding selector visually.\",\"created\":1692305939,\"installed\":false,\"core\":true},\"FieldtypeToggle\":{\"name\":\"FieldtypeToggle\",\"title\":\"Toggle (Yes\\/No)\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Configurable yes\\/no, on\\/off toggle alternative to a checkbox, plus optional \\u201cother\\u201d option.\",\"requiresVersions\":{\"InputfieldToggle\":[\">=\",0]},\"created\":1692305939,\"installed\":false,\"core\":true},\"FileCompilerTags\":{\"name\":\"FileCompilerTags\",\"title\":\"Tags File Compiler\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Enables {var} or {var.property} variables in markup sections of a file. Can be used with any API variable.\",\"created\":1692316720,\"installed\":false,\"configurable\":4,\"core\":true},\"ImageSizerEngineAnimatedGif\":{\"name\":\"ImageSizerEngineAnimatedGif\",\"title\":\"Animated GIF Image Sizer\",\"version\":1,\"versionStr\":\"0.0.1\",\"author\":\"Horst Nogajski\",\"summary\":\"Upgrades image manipulations for animated GIFs.\",\"created\":1692316744,\"installed\":false,\"configurable\":4,\"core\":true},\"ImageSizerEngineIMagick\":{\"name\":\"ImageSizerEngineIMagick\",\"title\":\"IMagick Image Sizer\",\"version\":3,\"versionStr\":\"0.0.3\",\"author\":\"Horst Nogajski\",\"summary\":\"Upgrades image manipulations to use PHP\'s ImageMagick library when possible.\",\"created\":1692316744,\"installed\":false,\"configurable\":4,\"core\":true},\"InputfieldCKEditor\":{\"name\":\"InputfieldCKEditor\",\"title\":\"CKEditor\",\"version\":171,\"versionStr\":\"1.7.1\",\"summary\":\"CKEditor textarea rich text editor.\",\"installs\":[\"MarkupHTMLPurifier\"],\"created\":1692316744,\"installed\":false,\"core\":true},\"InputfieldIcon\":{\"name\":\"InputfieldIcon\",\"title\":\"Icon\",\"version\":3,\"versionStr\":\"0.0.3\",\"summary\":\"Select an icon\",\"created\":1692305964,\"installed\":false,\"core\":true},\"InputfieldPageAutocomplete\":{\"name\":\"InputfieldPageAutocomplete\",\"title\":\"Page Auto Complete\",\"version\":113,\"versionStr\":\"1.1.3\",\"summary\":\"Multiple Page selection using auto completion and sorting capability. Intended for use as an input field for Page reference fields.\",\"created\":1692305965,\"installed\":false,\"core\":true},\"InputfieldPageTable\":{\"name\":\"InputfieldPageTable\",\"title\":\"ProFields: Page Table\",\"version\":14,\"versionStr\":\"0.1.4\",\"summary\":\"Inputfield to accompany FieldtypePageTable\",\"requiresVersions\":{\"FieldtypePageTable\":[\">=\",0]},\"created\":1692316768,\"installed\":false,\"core\":true},\"InputfieldTextTags\":{\"name\":\"InputfieldTextTags\",\"title\":\"Text Tags\",\"version\":5,\"versionStr\":\"0.0.5\",\"summary\":\"Enables input of user entered tags or selection of predefined tags.\",\"icon\":\"tags\",\"created\":1692305967,\"installed\":false,\"core\":true},\"InputfieldToggle\":{\"name\":\"InputfieldToggle\",\"title\":\"Toggle\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"A toggle providing similar input capability to a checkbox but much more configurable.\",\"created\":1692305975,\"installed\":false,\"core\":true},\"FieldtypePageTitleLanguage\":{\"name\":\"FieldtypePageTitleLanguage\",\"title\":\"Page Title (Multi-Language)\",\"version\":100,\"versionStr\":\"1.0.0\",\"author\":\"Ryan Cramer\",\"summary\":\"Field that stores a page title in multiple languages. Use this only if you want title inputs created for ALL languages on ALL pages. Otherwise create separate languaged-named title fields, i.e. title_fr, title_es, title_fi, etc. \",\"requiresVersions\":{\"LanguageSupportFields\":[\">=\",0],\"FieldtypeTextLanguage\":[\">=\",0]},\"created\":1692316784,\"installed\":false,\"core\":true},\"FieldtypeTextareaLanguage\":{\"name\":\"FieldtypeTextareaLanguage\",\"title\":\"Textarea (Multi-language)\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Field that stores a multiple lines of text in multiple languages\",\"requiresVersions\":{\"LanguageSupportFields\":[\">=\",0]},\"created\":1692316784,\"installed\":false,\"core\":true},\"FieldtypeTextLanguage\":{\"name\":\"FieldtypeTextLanguage\",\"title\":\"Text (Multi-language)\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Field that stores a single line of text in multiple languages\",\"requiresVersions\":{\"LanguageSupportFields\":[\">=\",0]},\"created\":1692316784,\"installed\":false,\"core\":true},\"LanguageSupport\":{\"name\":\"LanguageSupport\",\"title\":\"Languages Support\",\"version\":103,\"versionStr\":\"1.0.3\",\"author\":\"Ryan Cramer\",\"summary\":\"ProcessWire multi-language support.\",\"installs\":[\"ProcessLanguage\",\"ProcessLanguageTranslator\"],\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"configurable\":3,\"core\":true,\"addFlag\":32},\"LanguageSupportFields\":{\"name\":\"LanguageSupportFields\",\"title\":\"Languages Support - Fields\",\"version\":101,\"versionStr\":\"1.0.1\",\"author\":\"Ryan Cramer\",\"summary\":\"Required to use multi-language fields.\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0]},\"installs\":[\"FieldtypePageTitleLanguage\",\"FieldtypeTextareaLanguage\",\"FieldtypeTextLanguage\"],\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"core\":true},\"LanguageSupportPageNames\":{\"name\":\"LanguageSupportPageNames\",\"title\":\"Languages Support - Page Names\",\"version\":13,\"versionStr\":\"0.1.3\",\"author\":\"Ryan Cramer\",\"summary\":\"Required to use multi-language page names.\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0],\"LanguageSupportFields\":[\">=\",0]},\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"configurable\":4,\"core\":true},\"LanguageTabs\":{\"name\":\"LanguageTabs\",\"title\":\"Languages Support - Tabs\",\"version\":117,\"versionStr\":\"1.1.7\",\"author\":\"adamspruijt, ryan, flipzoom\",\"summary\":\"Organizes multi-language fields into tabs for a cleaner easier to use interface.\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0]},\"autoload\":\"template=admin\",\"singular\":true,\"created\":1692316784,\"installed\":false,\"configurable\":4,\"core\":true},\"ProcessLanguage\":{\"name\":\"ProcessLanguage\",\"title\":\"Languages\",\"version\":103,\"versionStr\":\"1.0.3\",\"author\":\"Ryan Cramer\",\"summary\":\"Manage system languages\",\"icon\":\"language\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0]},\"permission\":\"lang-edit\",\"permissions\":{\"lang-edit\":\"Administer languages and static translation files\"},\"created\":1692316784,\"installed\":false,\"configurable\":3,\"core\":true,\"useNavJSON\":true},\"ProcessLanguageTranslator\":{\"name\":\"ProcessLanguageTranslator\",\"title\":\"Language Translator\",\"version\":103,\"versionStr\":\"1.0.3\",\"author\":\"Ryan Cramer\",\"summary\":\"Provides language translation capabilities for ProcessWire core and modules.\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0]},\"permission\":\"lang-edit\",\"created\":1692316784,\"installed\":false,\"configurable\":4,\"core\":true},\"LazyCron\":{\"name\":\"LazyCron\",\"title\":\"Lazy Cron\",\"version\":103,\"versionStr\":\"1.0.3\",\"summary\":\"Provides hooks that are automatically executed at various intervals. It is called \'lazy\' because it\'s triggered by a pageview, so the interval is guaranteed to be at least the time requested, rather than exactly the time requested. This is fine for most cases, but you can make it not lazy by connecting this to a real CRON job. See the module file for details. \",\"href\":\"https:\\/\\/processwire.com\\/api\\/modules\\/lazy-cron\\/\",\"autoload\":true,\"singular\":true,\"created\":1692316720,\"installed\":false,\"core\":true},\"MarkupCache\":{\"name\":\"MarkupCache\",\"title\":\"Markup Cache\",\"version\":101,\"versionStr\":\"1.0.1\",\"summary\":\"A simple way to cache segments of markup in your templates. \",\"href\":\"https:\\/\\/processwire.com\\/api\\/modules\\/markupcache\\/\",\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"configurable\":3,\"core\":true},\"MarkupPageFields\":{\"name\":\"MarkupPageFields\",\"title\":\"Markup Page Fields\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Adds $page->renderFields() and $page->images->render() methods that return basic markup for output during development and debugging.\",\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"core\":true,\"permanent\":true},\"MarkupRSS\":{\"name\":\"MarkupRSS\",\"title\":\"Markup RSS Feed\",\"version\":105,\"versionStr\":\"1.0.5\",\"summary\":\"Renders an RSS feed. Given a PageArray, renders an RSS feed of them.\",\"icon\":\"rss-square\",\"created\":1692316784,\"installed\":false,\"configurable\":3,\"core\":true},\"PageFrontEdit\":{\"name\":\"PageFrontEdit\",\"title\":\"Front-End Page Editor\",\"version\":6,\"versionStr\":\"0.0.6\",\"author\":\"Ryan Cramer\",\"summary\":\"Enables front-end editing of page fields.\",\"icon\":\"cube\",\"permissions\":{\"page-edit-front\":\"Use the front-end page editor\"},\"autoload\":true,\"created\":1692305989,\"installed\":false,\"configurable\":\"PageFrontEditConfig.php\",\"core\":true,\"license\":\"MPL 2.0\"},\"PagePathHistory\":{\"name\":\"PagePathHistory\",\"title\":\"Page Path History\",\"version\":8,\"versionStr\":\"0.0.8\",\"summary\":\"Keeps track of past URLs where pages have lived and automatically redirects (301 permanent) to the new location whenever the past URL is accessed.\",\"autoload\":true,\"singular\":true,\"created\":1692316720,\"installed\":false,\"configurable\":4,\"core\":true},\"PagePaths\":{\"name\":\"PagePaths\",\"title\":\"Page Paths\",\"version\":4,\"versionStr\":\"0.0.4\",\"summary\":\"Enables page paths\\/urls to be queryable by selectors. Also offers potential for improved load performance. Builds an index at install (may take time on a large site).\",\"autoload\":true,\"singular\":true,\"created\":1692316720,\"installed\":false,\"configurable\":4,\"core\":true},\"ProcessCommentsManager\":{\"name\":\"ProcessCommentsManager\",\"title\":\"Comments\",\"version\":12,\"versionStr\":\"0.1.2\",\"author\":\"Ryan Cramer\",\"summary\":\"Manage comments in your site outside of the page editor.\",\"icon\":\"comments\",\"requiresVersions\":{\"FieldtypeComments\":[\">=\",0]},\"permission\":\"comments-manager\",\"permissions\":{\"comments-manager\":\"Use the comments manager\"},\"created\":1692316790,\"installed\":false,\"searchable\":\"comments\",\"core\":true,\"page\":{\"name\":\"comments\",\"parent\":\"setup\",\"title\":\"Comments\"},\"nav\":[{\"url\":\"?go=approved\",\"label\":\"Approved\"},{\"url\":\"?go=pending\",\"label\":\"Pending\"},{\"url\":\"?go=spam\",\"label\":\"Spam\"},{\"url\":\"?go=all\",\"label\":\"All\"}]},\"ProcessForgotPassword\":{\"name\":\"ProcessForgotPassword\",\"title\":\"Forgot Password\",\"version\":104,\"versionStr\":\"1.0.4\",\"summary\":\"Provides password reset\\/email capability for the Login process.\",\"permission\":\"page-view\",\"created\":1692305989,\"installed\":false,\"configurable\":4,\"core\":true},\"ProcessLogger\":{\"name\":\"ProcessLogger\",\"title\":\"Logs\",\"version\":2,\"versionStr\":\"0.0.2\",\"author\":\"Ryan Cramer\",\"summary\":\"View and manage system logs.\",\"icon\":\"tree\",\"permission\":\"logs-view\",\"permissions\":{\"logs-view\":\"Can view system logs\",\"logs-edit\":\"Can manage system logs\"},\"created\":1692305990,\"installed\":false,\"core\":true,\"page\":{\"name\":\"logs\",\"parent\":\"setup\",\"title\":\"Logs\"},\"useNavJSON\":true},\"ProcessPageClone\":{\"name\":\"ProcessPageClone\",\"title\":\"Page Clone\",\"version\":104,\"versionStr\":\"1.0.4\",\"summary\":\"Provides ability to clone\\/copy\\/duplicate pages in the admin. Adds a &quot;copy&quot; option to all applicable pages in the PageList.\",\"permission\":\"page-clone\",\"permissions\":{\"page-clone\":\"Clone a page\",\"page-clone-tree\":\"Clone a tree of pages\"},\"autoload\":\"template=admin\",\"created\":1692316790,\"installed\":false,\"core\":true,\"page\":{\"name\":\"clone\",\"title\":\"Clone\",\"parent\":\"page\",\"status\":1024}},\"ProcessPagesExportImport\":{\"name\":\"ProcessPagesExportImport\",\"title\":\"Pages Export\\/Import\",\"version\":1,\"versionStr\":\"0.0.1\",\"author\":\"Ryan Cramer\",\"summary\":\"Enables exporting and importing of pages. Development version, not yet recommended for production use.\",\"icon\":\"paper-plane-o\",\"permission\":\"page-edit-export\",\"created\":1692316794,\"installed\":false,\"core\":true,\"page\":{\"name\":\"export-import\",\"parent\":\"page\",\"title\":\"Export\\/Import\"}},\"ProcessRecentPages\":{\"name\":\"ProcessRecentPages\",\"title\":\"Recent Pages\",\"version\":2,\"versionStr\":\"0.0.2\",\"author\":\"Ryan Cramer\",\"summary\":\"Shows a list of recently edited pages in your admin.\",\"href\":\"http:\\/\\/modules.processwire.com\\/\",\"icon\":\"clock-o\",\"permission\":\"page-edit-recent\",\"permissions\":{\"page-edit-recent\":\"Can see recently edited pages\"},\"created\":1692305992,\"installed\":false,\"core\":true,\"page\":{\"name\":\"recent-pages\",\"parent\":\"page\",\"title\":\"Recent\"},\"useNavJSON\":true,\"nav\":[{\"url\":\"?edited=1\",\"label\":\"Edited\",\"icon\":\"users\",\"navJSON\":\"navJSON\\/?edited=1\"},{\"url\":\"?added=1\",\"label\":\"Created\",\"icon\":\"users\",\"navJSON\":\"navJSON\\/?added=1\"},{\"url\":\"?edited=1&me=1\",\"label\":\"Edited by me\",\"icon\":\"user\",\"navJSON\":\"navJSON\\/?edited=1&me=1\"},{\"url\":\"?added=1&me=1\",\"label\":\"Created by me\",\"icon\":\"user\",\"navJSON\":\"navJSON\\/?added=1&me=1\"},{\"url\":\"another\\/\",\"label\":\"Add another\",\"icon\":\"plus-circle\",\"navJSON\":\"anotherNavJSON\\/\"}]},\"ProcessSessionDB\":{\"name\":\"ProcessSessionDB\",\"title\":\"Sessions\",\"version\":5,\"versionStr\":\"0.0.5\",\"summary\":\"Enables you to browse active database sessions.\",\"icon\":\"dashboard\",\"requiresVersions\":{\"SessionHandlerDB\":[\">=\",0]},\"created\":1692316794,\"installed\":false,\"core\":true,\"page\":{\"name\":\"sessions-db\",\"parent\":\"access\",\"title\":\"Sessions\"}},\"SessionHandlerDB\":{\"name\":\"SessionHandlerDB\",\"title\":\"Session Handler Database\",\"version\":6,\"versionStr\":\"0.0.6\",\"summary\":\"Installing this module makes ProcessWire store sessions in the database rather than the file system. Note that this module will log you out after install or uninstall.\",\"installs\":[\"ProcessSessionDB\"],\"created\":1692316794,\"installed\":false,\"configurable\":3,\"core\":true},\"FieldtypeNotifications\":{\"name\":\"FieldtypeNotifications\",\"title\":\"Notifications\",\"version\":4,\"versionStr\":\"0.0.4\",\"summary\":\"Field that stores user notifications.\",\"requiresVersions\":{\"SystemNotifications\":[\">=\",0]},\"created\":1692316794,\"installed\":false,\"core\":true},\"SystemNotifications\":{\"name\":\"SystemNotifications\",\"title\":\"System Notifications\",\"version\":12,\"versionStr\":\"0.1.2\",\"summary\":\"Adds support for notifications in ProcessWire (currently in development)\",\"icon\":\"bell\",\"installs\":[\"FieldtypeNotifications\"],\"autoload\":true,\"created\":1692316796,\"installed\":false,\"configurable\":\"SystemNotificationsConfig.php\",\"core\":true},\"TextformatterMarkdownExtra\":{\"name\":\"TextformatterMarkdownExtra\",\"title\":\"Markdown\\/Parsedown Extra\",\"version\":180,\"versionStr\":\"1.8.0\",\"summary\":\"Markdown\\/Parsedown extra lightweight markup language by Emanuil Rusev. Based on Markdown by John Gruber.\",\"created\":1692305995,\"installed\":false,\"configurable\":4,\"core\":true},\"TextformatterNewlineBR\":{\"name\":\"TextformatterNewlineBR\",\"title\":\"Newlines to XHTML Line Breaks\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Converts newlines to XHTML line break <br \\/> tags. \",\"created\":1692316796,\"installed\":false,\"core\":true},\"TextformatterNewlineUL\":{\"name\":\"TextformatterNewlineUL\",\"title\":\"Newlines to Unordered List\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Converts newlines to <li> list items and surrounds in an <ul> unordered list. \",\"created\":1692316796,\"installed\":false,\"core\":true},\"TextformatterPstripper\":{\"name\":\"TextformatterPstripper\",\"title\":\"Paragraph Stripper\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Strips paragraph <p> tags that may have been applied by other text formatters before it. \",\"created\":1692316796,\"installed\":false,\"core\":true},\"TextformatterSmartypants\":{\"name\":\"TextformatterSmartypants\",\"title\":\"SmartyPants Typographer\",\"version\":171,\"versionStr\":\"1.7.1\",\"summary\":\"Smart typography for web sites, by Michel Fortin based on SmartyPants by John Gruber. If combined with Markdown, it should be applied AFTER Markdown.\",\"created\":1692316796,\"installed\":false,\"configurable\":4,\"core\":true,\"url\":\"https:\\/\\/github.com\\/michelf\\/php-smartypants\"},\"TextformatterStripTags\":{\"name\":\"TextformatterStripTags\",\"title\":\"Strip Markup Tags\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Strips HTML\\/XHTML Markup Tags\",\"created\":1692316796,\"installed\":false,\"configurable\":3,\"core\":true},\"InputfieldFormBuilderForm\":{\"name\":\"InputfieldFormBuilderForm\",\"title\":\"Form (for FormBuilder)\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Enables you to include one FormBuilder form within another.\",\"requiresVersions\":{\"FormBuilder\":[\">=\",0]},\"created\":1694331233,\"installed\":false},\"InputfieldFormBuilderPageBreak\":{\"name\":\"InputfieldFormBuilderPageBreak\",\"title\":\"Page Break (for FormBuilder)\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Enables you to create separate paginations of a form in FormBuilder.\",\"requiresVersions\":{\"FormBuilder\":[\">=\",0]},\"created\":1694331233,\"installed\":false},\"FrontendForms\":{\"name\":\"FrontendForms\",\"title\":\"FrontendForms\",\"version\":\"2.1.43\",\"versionStr\":\"2.1.43\",\"author\":\"J\\u00fcrgen Kern\",\"summary\":\"Create forms and validate them using the Valitron library.\",\"href\":\"https:\\/\\/github.com\\/juergenweb\\/FrontendForms\",\"requiresVersions\":{\"PHP\":[\">=\",\"8.0.0\"],\"ProcessWire\":[\">=\",\"3.0.181\"]},\"autoload\":true,\"singular\":true,\"created\":1693550148,\"installed\":false,\"configurable\":4}}', '2010-04-08 03:10:01'),
('ModulesVersions.info', '[]', '2010-04-08 03:10:01');
INSERT INTO `caches` (`name`, `data`, `expires`) VALUES
('Modules.info', '{\"148\":{\"name\":\"AdminThemeDefault\",\"title\":\"Default\",\"version\":14,\"autoload\":\"template=admin\",\"created\":1692306124,\"configurable\":19},\"166\":{\"name\":\"AdminThemeUikit\",\"title\":\"Uikit\",\"version\":33,\"autoload\":\"template=admin\",\"created\":1692306146,\"configurable\":4},\"97\":{\"name\":\"FieldtypeCheckbox\",\"title\":\"Checkbox\",\"version\":101,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"28\":{\"name\":\"FieldtypeDatetime\",\"title\":\"Datetime\",\"version\":105,\"created\":1692306124},\"29\":{\"name\":\"FieldtypeEmail\",\"title\":\"E-Mail\",\"version\":101,\"created\":1692306124},\"106\":{\"name\":\"FieldtypeFieldsetClose\",\"title\":\"Fieldset (Close)\",\"version\":100,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"105\":{\"name\":\"FieldtypeFieldsetOpen\",\"title\":\"Fieldset (Open)\",\"version\":101,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"107\":{\"name\":\"FieldtypeFieldsetTabOpen\",\"title\":\"Fieldset in Tab (Open)\",\"version\":100,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"6\":{\"name\":\"FieldtypeFile\",\"title\":\"Files\",\"version\":107,\"created\":1692306124,\"configurable\":4,\"permanent\":true},\"89\":{\"name\":\"FieldtypeFloat\",\"title\":\"Float\",\"version\":107,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"57\":{\"name\":\"FieldtypeImage\",\"title\":\"Images\",\"version\":102,\"created\":1692306124,\"configurable\":4,\"permanent\":true},\"84\":{\"name\":\"FieldtypeInteger\",\"title\":\"Integer\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"27\":{\"name\":\"FieldtypeModule\",\"title\":\"Module Reference\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"173\":{\"name\":\"FieldtypeOptions\",\"title\":\"Select Options\",\"version\":2,\"singular\":true,\"created\":1692366848},\"4\":{\"name\":\"FieldtypePage\",\"title\":\"Page Reference\",\"version\":107,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"111\":{\"name\":\"FieldtypePageTitle\",\"title\":\"Page Title\",\"version\":100,\"singular\":true,\"created\":1692306124,\"permanent\":true},\"133\":{\"name\":\"FieldtypePassword\",\"title\":\"Password\",\"version\":101,\"singular\":true,\"created\":1692306124,\"permanent\":true},\"174\":{\"name\":\"FieldtypeSelector\",\"title\":\"Selector\",\"version\":13,\"singular\":1,\"created\":1692366863},\"3\":{\"name\":\"FieldtypeText\",\"title\":\"Text\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"1\":{\"name\":\"FieldtypeTextarea\",\"title\":\"Textarea\",\"version\":107,\"created\":1692306124,\"permanent\":true},\"175\":{\"name\":\"FieldtypeToggle\",\"title\":\"Toggle (Yes\\/No)\",\"version\":1,\"requiresVersions\":{\"InputfieldToggle\":[\">=\",0]},\"singular\":true,\"created\":1692735599},\"135\":{\"name\":\"FieldtypeURL\",\"title\":\"URL\",\"version\":101,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"25\":{\"name\":\"InputfieldAsmSelect\",\"title\":\"asmSelect\",\"version\":203,\"created\":1692306124,\"permanent\":true},\"131\":{\"name\":\"InputfieldButton\",\"title\":\"Button\",\"version\":100,\"created\":1692306124,\"permanent\":true},\"37\":{\"name\":\"InputfieldCheckbox\",\"title\":\"Checkbox\",\"version\":106,\"created\":1692306124,\"permanent\":true},\"38\":{\"name\":\"InputfieldCheckboxes\",\"title\":\"Checkboxes\",\"version\":108,\"created\":1692306124,\"permanent\":true},\"94\":{\"name\":\"InputfieldDatetime\",\"title\":\"Datetime\",\"version\":107,\"created\":1692306124,\"permanent\":true},\"80\":{\"name\":\"InputfieldEmail\",\"title\":\"Email\",\"version\":102,\"created\":1692306124},\"78\":{\"name\":\"InputfieldFieldset\",\"title\":\"Fieldset\",\"version\":101,\"created\":1692306124,\"permanent\":true},\"55\":{\"name\":\"InputfieldFile\",\"title\":\"Files\",\"version\":128,\"created\":1692306124,\"permanent\":true},\"90\":{\"name\":\"InputfieldFloat\",\"title\":\"Float\",\"version\":105,\"created\":1692306124,\"permanent\":true},\"30\":{\"name\":\"InputfieldForm\",\"title\":\"Form\",\"version\":107,\"created\":1692306124,\"permanent\":true},\"40\":{\"name\":\"InputfieldHidden\",\"title\":\"Hidden\",\"version\":101,\"created\":1692306124,\"permanent\":true},\"168\":{\"name\":\"InputfieldIcon\",\"title\":\"Icon\",\"version\":3,\"created\":1692306150},\"56\":{\"name\":\"InputfieldImage\",\"title\":\"Images\",\"version\":126,\"created\":1692306124,\"permanent\":true},\"85\":{\"name\":\"InputfieldInteger\",\"title\":\"Integer\",\"version\":105,\"created\":1692306124,\"permanent\":true},\"79\":{\"name\":\"InputfieldMarkup\",\"title\":\"Markup\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"41\":{\"name\":\"InputfieldName\",\"title\":\"Name\",\"version\":100,\"created\":1692306124,\"permanent\":true},\"60\":{\"name\":\"InputfieldPage\",\"title\":\"Page\",\"version\":108,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"170\":{\"name\":\"InputfieldPageAutocomplete\",\"title\":\"Page Auto Complete\",\"version\":113,\"created\":1692307988},\"15\":{\"name\":\"InputfieldPageListSelect\",\"title\":\"Page List Select\",\"version\":101,\"created\":1692306124,\"permanent\":true},\"137\":{\"name\":\"InputfieldPageListSelectMultiple\",\"title\":\"Page List Select Multiple\",\"version\":103,\"created\":1692306124,\"permanent\":true},\"86\":{\"name\":\"InputfieldPageName\",\"title\":\"Page Name\",\"version\":106,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"112\":{\"name\":\"InputfieldPageTitle\",\"title\":\"Page Title\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"122\":{\"name\":\"InputfieldPassword\",\"title\":\"Password\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"39\":{\"name\":\"InputfieldRadios\",\"title\":\"Radio Buttons\",\"version\":106,\"created\":1692306124,\"permanent\":true},\"36\":{\"name\":\"InputfieldSelect\",\"title\":\"Select\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"43\":{\"name\":\"InputfieldSelectMultiple\",\"title\":\"Select Multiple\",\"version\":101,\"created\":1692306124,\"permanent\":true},\"149\":{\"name\":\"InputfieldSelector\",\"title\":\"Selector\",\"version\":28,\"autoload\":\"template=admin\",\"created\":1692306124,\"configurable\":3,\"addFlag\":32},\"32\":{\"name\":\"InputfieldSubmit\",\"title\":\"Submit\",\"version\":103,\"created\":1692306124,\"permanent\":true},\"34\":{\"name\":\"InputfieldText\",\"title\":\"Text\",\"version\":106,\"created\":1692306124,\"permanent\":true},\"35\":{\"name\":\"InputfieldTextarea\",\"title\":\"Textarea\",\"version\":103,\"created\":1692306124,\"permanent\":true},\"169\":{\"name\":\"InputfieldTextTags\",\"title\":\"Text Tags\",\"version\":5,\"icon\":\"tags\",\"created\":1692307413},\"155\":{\"name\":\"InputfieldTinyMCE\",\"title\":\"TinyMCE\",\"version\":615,\"icon\":\"keyboard-o\",\"requiresVersions\":{\"ProcessWire\":[\">=\",\"3.0.200\"],\"MarkupHTMLPurifier\":[\">=\",0]},\"created\":1692306124,\"configurable\":4},\"172\":{\"name\":\"InputfieldToggle\",\"title\":\"Toggle\",\"version\":1,\"created\":1692308746},\"108\":{\"name\":\"InputfieldURL\",\"title\":\"URL\",\"version\":103,\"created\":1692306124},\"116\":{\"name\":\"JqueryCore\",\"title\":\"jQuery Core\",\"version\":\"1.12.4\",\"singular\":true,\"created\":1692306124,\"permanent\":true},\"151\":{\"name\":\"JqueryMagnific\",\"title\":\"jQuery Magnific Popup\",\"version\":\"1.1.0\",\"singular\":1,\"created\":1692306124},\"103\":{\"name\":\"JqueryTableSorter\",\"title\":\"jQuery Table Sorter Plugin\",\"version\":\"2.31.3\",\"singular\":1,\"created\":1692306124},\"117\":{\"name\":\"JqueryUI\",\"title\":\"jQuery UI\",\"version\":\"1.10.4\",\"singular\":true,\"created\":1692306124,\"permanent\":true},\"45\":{\"name\":\"JqueryWireTabs\",\"title\":\"jQuery Wire Tabs Plugin\",\"version\":110,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"67\":{\"name\":\"MarkupAdminDataTable\",\"title\":\"Admin Data Table\",\"version\":107,\"created\":1692306124,\"permanent\":true},\"156\":{\"name\":\"MarkupHTMLPurifier\",\"title\":\"HTML Purifier\",\"version\":497,\"created\":1692306124},\"113\":{\"name\":\"MarkupPageArray\",\"title\":\"PageArray Markup\",\"version\":100,\"autoload\":true,\"singular\":true,\"created\":1692306124},\"98\":{\"name\":\"MarkupPagerNav\",\"title\":\"Pager (Pagination) Navigation\",\"version\":105,\"created\":1692306124},\"176\":{\"name\":\"PageFrontEdit\",\"title\":\"Front-End Page Editor\",\"version\":6,\"icon\":\"cube\",\"autoload\":true,\"created\":1692744294,\"configurable\":\"PageFrontEditConfig.php\"},\"114\":{\"name\":\"PagePermissions\",\"title\":\"Page Permissions\",\"version\":105,\"autoload\":true,\"singular\":true,\"created\":1692306124,\"permanent\":true},\"115\":{\"name\":\"PageRender\",\"title\":\"Page Render\",\"version\":105,\"autoload\":true,\"singular\":true,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"48\":{\"name\":\"ProcessField\",\"title\":\"Fields\",\"version\":114,\"icon\":\"cube\",\"permission\":\"field-admin\",\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true,\"addFlag\":32},\"178\":{\"name\":\"ProcessForgotPassword\",\"title\":\"Forgot Password\",\"version\":104,\"permission\":\"page-view\",\"singular\":1,\"created\":1693533168,\"configurable\":4},\"87\":{\"name\":\"ProcessHome\",\"title\":\"Admin Home\",\"version\":101,\"permission\":\"page-view\",\"created\":1692306124,\"permanent\":true},\"76\":{\"name\":\"ProcessList\",\"title\":\"List\",\"version\":101,\"permission\":\"page-view\",\"created\":1692306124,\"permanent\":true},\"167\":{\"name\":\"ProcessLogger\",\"title\":\"Logs\",\"version\":2,\"icon\":\"tree\",\"permission\":\"logs-view\",\"singular\":1,\"created\":1692306150,\"useNavJSON\":true},\"10\":{\"name\":\"ProcessLogin\",\"title\":\"Login\",\"version\":109,\"permission\":\"page-view\",\"created\":1692306124,\"configurable\":4,\"permanent\":true},\"50\":{\"name\":\"ProcessModule\",\"title\":\"Modules\",\"version\":120,\"permission\":\"module-admin\",\"created\":1692306124,\"permanent\":true,\"useNavJSON\":true,\"nav\":[{\"url\":\"?site#tab_site_modules\",\"label\":\"Site\",\"icon\":\"plug\",\"navJSON\":\"navJSON\\/?site=1\"},{\"url\":\"?core#tab_core_modules\",\"label\":\"Core\",\"icon\":\"plug\",\"navJSON\":\"navJSON\\/?core=1\"},{\"url\":\"?configurable#tab_configurable_modules\",\"label\":\"Configure\",\"icon\":\"gear\",\"navJSON\":\"navJSON\\/?configurable=1\"},{\"url\":\"?install#tab_install_modules\",\"label\":\"Install\",\"icon\":\"sign-in\",\"navJSON\":\"navJSON\\/?install=1\"},{\"url\":\"?new#tab_new_modules\",\"label\":\"New\",\"icon\":\"plus\"},{\"url\":\"?reset=1\",\"label\":\"Refresh\",\"icon\":\"refresh\"}]},\"17\":{\"name\":\"ProcessPageAdd\",\"title\":\"Page Add\",\"version\":109,\"icon\":\"plus-circle\",\"permission\":\"page-edit\",\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"7\":{\"name\":\"ProcessPageEdit\",\"title\":\"Page Edit\",\"version\":112,\"icon\":\"edit\",\"permission\":\"page-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"129\":{\"name\":\"ProcessPageEditImageSelect\",\"title\":\"Page Edit Image\",\"version\":121,\"permission\":\"page-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"121\":{\"name\":\"ProcessPageEditLink\",\"title\":\"Page Edit Link\",\"version\":112,\"icon\":\"link\",\"permission\":\"page-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":4,\"permanent\":true},\"12\":{\"name\":\"ProcessPageList\",\"title\":\"Page List\",\"version\":124,\"icon\":\"sitemap\",\"permission\":\"page-edit\",\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"150\":{\"name\":\"ProcessPageLister\",\"title\":\"Lister\",\"version\":26,\"icon\":\"search\",\"permission\":\"page-lister\",\"created\":1692306124,\"configurable\":true,\"permanent\":true,\"useNavJSON\":true,\"addFlag\":32},\"104\":{\"name\":\"ProcessPageSearch\",\"title\":\"Page Search\",\"version\":108,\"permission\":\"page-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"14\":{\"name\":\"ProcessPageSort\",\"title\":\"Page Sort and Move\",\"version\":100,\"permission\":\"page-edit\",\"created\":1692306124,\"permanent\":true},\"109\":{\"name\":\"ProcessPageTrash\",\"title\":\"Page Trash\",\"version\":103,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"134\":{\"name\":\"ProcessPageType\",\"title\":\"Page Type\",\"version\":101,\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true,\"addFlag\":32},\"83\":{\"name\":\"ProcessPageView\",\"title\":\"Page View\",\"version\":106,\"permission\":\"page-view\",\"created\":1692306124,\"permanent\":true},\"136\":{\"name\":\"ProcessPermission\",\"title\":\"Permissions\",\"version\":101,\"icon\":\"gear\",\"permission\":\"permission-admin\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"138\":{\"name\":\"ProcessProfile\",\"title\":\"User Profile\",\"version\":105,\"permission\":\"profile-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"165\":{\"name\":\"ProcessRecentPages\",\"title\":\"Recent Pages\",\"version\":2,\"icon\":\"clock-o\",\"permission\":\"page-edit-recent\",\"singular\":1,\"created\":1692306145,\"useNavJSON\":true,\"nav\":[{\"url\":\"?edited=1\",\"label\":\"Edited\",\"icon\":\"users\",\"navJSON\":\"navJSON\\/?edited=1\"},{\"url\":\"?added=1\",\"label\":\"Created\",\"icon\":\"users\",\"navJSON\":\"navJSON\\/?added=1\"},{\"url\":\"?edited=1&me=1\",\"label\":\"Edited by me\",\"icon\":\"user\",\"navJSON\":\"navJSON\\/?edited=1&me=1\"},{\"url\":\"?added=1&me=1\",\"label\":\"Created by me\",\"icon\":\"user\",\"navJSON\":\"navJSON\\/?added=1&me=1\"},{\"url\":\"another\\/\",\"label\":\"Add another\",\"icon\":\"plus-circle\",\"navJSON\":\"anotherNavJSON\\/\"}]},\"68\":{\"name\":\"ProcessRole\",\"title\":\"Roles\",\"version\":104,\"icon\":\"gears\",\"permission\":\"role-admin\",\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"47\":{\"name\":\"ProcessTemplate\",\"title\":\"Templates\",\"version\":114,\"icon\":\"cubes\",\"permission\":\"template-admin\",\"created\":1692306124,\"configurable\":4,\"permanent\":true,\"useNavJSON\":true},\"66\":{\"name\":\"ProcessUser\",\"title\":\"Users\",\"version\":107,\"icon\":\"group\",\"permission\":\"user-admin\",\"created\":1692306124,\"configurable\":\"ProcessUserConfig.php\",\"permanent\":true,\"useNavJSON\":true},\"125\":{\"name\":\"SessionLoginThrottle\",\"title\":\"Session Login Throttle\",\"version\":103,\"autoload\":\"function\",\"singular\":true,\"created\":1692306124,\"configurable\":3},\"139\":{\"name\":\"SystemUpdater\",\"title\":\"System Updater\",\"version\":20,\"singular\":true,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"61\":{\"name\":\"TextformatterEntities\",\"title\":\"HTML Entity Encoder (htmlspecialchars)\",\"version\":100,\"created\":1692306124},\"171\":{\"name\":\"TextformatterMarkdownExtra\",\"title\":\"Markdown\\/Parsedown Extra\",\"version\":180,\"singular\":1,\"created\":1692308006,\"configurable\":4},\"177\":{\"name\":\"LoginRegister\",\"title\":\"Login\\/Register\",\"version\":2,\"icon\":\"user-plus\",\"created\":1693532993,\"configurable\":4},\"179\":{\"name\":\"FormBuilder\",\"title\":\"Form Builder\",\"version\":46,\"installs\":[\"ProcessFormBuilder\",\"InputfieldFormBuilderFile\"],\"autoload\":true,\"singular\":true,\"configurable\":true},\"180\":{\"name\":\"ProcessFormBuilder\",\"title\":\"Forms\",\"version\":46,\"icon\":\"building\",\"requiresVersions\":{\"FormBuilder\":[\">=\",0]},\"permission\":\"form-builder\",\"singular\":true,\"useNavJSON\":true,\"nav\":[{\"url\":\"?entries\",\"label\":\"Entries\",\"icon\":\"server\",\"navJSON\":\"navJSON\\/?get=entries\"},{\"url\":\"?edit\",\"label\":\"Edit\",\"icon\":\"pencil-square-o\",\"navJSON\":\"navJSON\\/?get=edit\"},{\"url\":\"addForm\\/\",\"label\":\"Add New\",\"icon\":\"plus-circle\",\"permission\":\"form-builder-add\"}]},\"181\":{\"name\":\"InputfieldFormBuilderFile\",\"title\":\"File (for FormBuilder)\",\"version\":2,\"requiresVersions\":{\"FormBuilder\":[\">=\",0]}}}', '2010-04-08 03:10:01'),
('Permissions.names', '{\"form-builder\":1161,\"form-builder-add\":1162,\"logs-edit\":1014,\"logs-view\":1013,\"page-delete\":34,\"page-edit\":32,\"page-edit-front\":1042,\"page-edit-recent\":1011,\"page-lister\":1006,\"page-lock\":54,\"page-move\":35,\"page-sort\":50,\"page-template\":51,\"page-view\":36,\"profile-edit\":53,\"user-admin\":52}', '2010-04-08 03:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `fieldgroups`
--

CREATE TABLE `fieldgroups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `fieldgroups`
--

INSERT INTO `fieldgroups` (`id`, `name`) VALUES
(2, 'admin'),
(3, 'user'),
(4, 'role'),
(5, 'permission'),
(1, 'home'),
(83, 'basic-page'),
(112, 'login'),
(111, 'profile'),
(110, 'daily_duties_form'),
(108, 'course_category'),
(101, 'forms'),
(102, 'form_page'),
(103, 'courses'),
(104, 'instructor'),
(105, 'course_page'),
(106, 'all-courses'),
(107, 'course_material'),
(113, 'form_submit_user'),
(114, 'daily_duties_data'),
(115, 'generator_portal_form'),
(116, 'generator_portal_data'),
(117, 'emergency_numbers'),
(118, 'daily_duties_list'),
(119, 'generator_portal_list'),
(120, 'form-builder');

-- --------------------------------------------------------

--
-- Table structure for table `fieldgroups_fields`
--

CREATE TABLE `fieldgroups_fields` (
  `fieldgroups_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `fields_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `data` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `fieldgroups_fields`
--

INSERT INTO `fieldgroups_fields` (`fieldgroups_id`, `fields_id`, `sort`, `data`) VALUES
(2, 2, 1, NULL),
(2, 1, 0, NULL),
(3, 4, 2, NULL),
(3, 92, 1, NULL),
(4, 5, 0, NULL),
(5, 1, 0, NULL),
(3, 3, 0, NULL),
(83, 1, 0, NULL),
(1, 1, 0, NULL),
(3, 97, 3, NULL),
(102, 103, 4, NULL),
(102, 100, 1, NULL),
(105, 106, 7, NULL),
(105, 99, 6, NULL),
(108, 100, 1, NULL),
(108, 1, 0, NULL),
(106, 100, 3, NULL),
(101, 1, 0, NULL),
(102, 101, 2, NULL),
(83, 100, 1, NULL),
(101, 100, 1, NULL),
(102, 107, 3, NULL),
(102, 1, 0, NULL),
(108, 103, 2, NULL),
(103, 100, 2, NULL),
(103, 98, 1, NULL),
(103, 1, 0, NULL),
(104, 1, 0, NULL),
(104, 100, 1, NULL),
(104, 102, 2, NULL),
(105, 1, 0, NULL),
(105, 100, 1, NULL),
(105, 103, 2, NULL),
(103, 99, 3, NULL),
(106, 99, 2, NULL),
(106, 98, 1, NULL),
(106, 1, 0, NULL),
(105, 98, 5, NULL),
(105, 105, 3, NULL),
(105, 104, 4, NULL),
(107, 1, 0, NULL),
(107, 98, 1, NULL),
(107, 99, 2, NULL),
(110, 103, 1, NULL),
(110, 100, 2, NULL),
(110, 105, 3, NULL),
(110, 1, 0, NULL),
(110, 107, 4, NULL),
(110, 101, 5, NULL),
(111, 1, 0, NULL),
(112, 1, 0, NULL),
(113, 1, 0, NULL),
(113, 108, 1, NULL),
(114, 109, 1, NULL),
(114, 108, 2, NULL),
(114, 1, 0, NULL),
(114, 100, 3, NULL),
(114, 111, 4, NULL),
(114, 115, 5, NULL),
(114, 114, 6, NULL),
(114, 113, 7, NULL),
(114, 118, 8, NULL),
(114, 117, 9, NULL),
(114, 119, 10, NULL),
(114, 120, 11, NULL),
(114, 121, 12, NULL),
(114, 116, 13, NULL),
(114, 112, 14, NULL),
(115, 108, 2, NULL),
(115, 109, 1, NULL),
(116, 100, 1, NULL),
(115, 101, 4, NULL),
(116, 101, 2, NULL),
(116, 1, 0, NULL),
(115, 1, 0, NULL),
(115, 121, 3, NULL),
(115, 103, 5, NULL),
(115, 100, 6, NULL),
(116, 108, 3, NULL),
(116, 109, 4, NULL),
(117, 1, 0, NULL),
(117, 98, 1, NULL),
(117, 99, 2, NULL),
(117, 100, 3, NULL),
(118, 1, 0, NULL),
(118, 98, 1, NULL),
(118, 99, 2, NULL),
(119, 1, 0, NULL),
(120, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(128) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `name` varchar(250) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `flags` int(11) NOT NULL DEFAULT 0,
  `label` varchar(250) NOT NULL DEFAULT '',
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `type`, `name`, `flags`, `label`, `data`) VALUES
(1, 'FieldtypePageTitle', 'title', 13, 'Title', '{\"required\":1,\"textformatters\":[\"TextformatterEntities\"],\"size\":0,\"maxlength\":255}'),
(2, 'FieldtypeModule', 'process', 25, 'Process', '{\"description\":\"The process that is executed on this page. Since this is mostly used by ProcessWire internally, it is recommended that you don\'t change the value of this unless adding your own pages in the admin.\",\"collapsed\":1,\"required\":1,\"moduleTypes\":[\"Process\"],\"permanent\":1}'),
(3, 'FieldtypePassword', 'pass', 24, 'Set Password', '{\"collapsed\":1,\"size\":50,\"maxlength\":128}'),
(5, 'FieldtypePage', 'permissions', 24, 'Permissions', '{\"derefAsPage\":0,\"parent_id\":31,\"labelFieldName\":\"title\",\"inputfield\":\"InputfieldCheckboxes\"}'),
(4, 'FieldtypePage', 'roles', 24, 'Roles', '{\"derefAsPage\":0,\"parent_id\":30,\"labelFieldName\":\"name\",\"inputfield\":\"InputfieldCheckboxes\",\"description\":\"User will inherit the permissions assigned to each role. You may assign multiple roles to a user. When accessing a page, the user will only inherit permissions from the roles that are also assigned to the page\'s template.\"}'),
(92, 'FieldtypeEmail', 'email', 9, 'E-Mail Address', '{\"size\":70,\"maxlength\":255}'),
(97, 'FieldtypeModule', 'admin_theme', 8, 'Admin Theme', '{\"moduleTypes\":[\"AdminTheme\"],\"labelField\":\"title\",\"inputfieldClass\":\"InputfieldRadios\"}'),
(98, 'FieldtypeTextarea', 'page_body', 0, 'page_body', '{\"inputfieldClass\":\"InputfieldTinyMCE\",\"contentType\":1}'),
(99, 'FieldtypeImage', 'page_images', 0, 'page_images', '{\"fileSchema\":270,\"maxFiles\":0,\"extensions\":\"gif jpg jpeg png\",\"outputFormat\":0,\"descriptionRows\":1,\"useTags\":0,\"collapsed\":0,\"gridMode\":\"grid\",\"focusMode\":\"on\",\"resizeServer\":0,\"clientQuality\":90,\"maxReject\":0,\"dimensionsByAspectRatio\":0,\"defaultValuePage\":0,\"inputfieldClass\":\"InputfieldImage\"}'),
(100, 'FieldtypeText', 'short_description', 0, 'short_description', '{\"textformatters\":[\"TextformatterEntities\"]}'),
(101, 'FieldtypeOptions', 'form_visibility', 0, 'form_visibility', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(102, 'FieldtypeImage', 'profile_photo', 0, 'profile_photo', '{\"fileSchema\":270,\"maxFiles\":1,\"extensions\":\"gif jpg jpeg png\",\"outputFormat\":0,\"descriptionRows\":1,\"useTags\":0,\"gridMode\":\"grid\",\"focusMode\":\"on\",\"resizeServer\":0,\"clientQuality\":90,\"maxReject\":0,\"dimensionsByAspectRatio\":0,\"defaultValuePage\":0,\"inputfieldClass\":\"InputfieldImage\"}'),
(103, 'FieldtypeImage', 'thumbnail', 0, 'Thumbnail', '{\"fileSchema\":270,\"maxFiles\":1,\"extensions\":\"gif jpg jpeg png\",\"outputFormat\":0,\"descriptionRows\":1,\"useTags\":0,\"collapsed\":0,\"gridMode\":\"grid\",\"focusMode\":\"on\",\"resizeServer\":0,\"clientQuality\":90,\"maxReject\":0,\"dimensionsByAspectRatio\":0,\"defaultValuePage\":0,\"inputfieldClass\":\"InputfieldImage\"}'),
(104, 'FieldtypePage', 'course_category', 0, 'course category', '{\"derefAsPage\":0,\"inputfield\":\"InputfieldCheckboxes\",\"distinctAutojoin\":true,\"optionColumns\":0,\"parent_id\":1034,\"labelFieldName\":\"title\",\"collapsed\":0}'),
(105, 'FieldtypeToggle', 'is_featured', 0, 'is Featured', '{\"formatType\":0,\"labelType\":0,\"inputfieldClass\":0,\"useVertical\":0,\"yesLabel\":\"\\u2713\",\"noLabel\":\"\\u2717\",\"otherLabel\":\"?\",\"defaultOption\":\"none\",\"collapsed\":0}'),
(106, 'FieldtypePage', 'instructor', 0, 'instructor', '{\"derefAsPage\":0,\"inputfield\":\"InputfieldCheckboxes\",\"distinctAutojoin\":true,\"optionColumns\":0,\"parent_id\":1025,\"labelFieldName\":\"title\",\"collapsed\":0}'),
(107, 'FieldtypeText', 'form_edit_fields', 0, 'Form Edit Fields', '{\"textformatters\":[\"TextformatterEntities\"],\"collapsed\":0,\"minlength\":0,\"maxlength\":2048,\"showCount\":0,\"size\":0}'),
(108, 'FieldtypePage', 'user_id', 0, 'user_id', '{\"derefAsPage\":2,\"inputfield\":\"InputfieldSelect\",\"distinctAutojoin\":true,\"parent_id\":0,\"template_id\":3,\"labelFieldName\":\"title\",\"collapsed\":0}'),
(109, 'FieldtypeDatetime', 'date', 0, 'date', '{\"dateOutputFormat\":\"Y.n.j H:i:s\",\"dateInputFormat\":\"Y-m-d\",\"timeInputFormat\":\"g:i a\",\"inputType\":\"html\",\"htmlType\":\"date\",\"collapsed\":0,\"dateSelectFormat\":\"yMd\",\"yearFrom\":1923,\"yearTo\":2043,\"yearLock\":0,\"datepicker\":0,\"timeInputSelect\":0,\"size\":25,\"defaultToday\":1}'),
(111, 'FieldtypeOptions', 'ac_input', 0, 'ac_input', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(112, 'FieldtypeOptions', 'room_alert', 0, 'Room Alert', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(113, 'FieldtypeOptions', 'backup_vps', 0, 'Backup VPS', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(114, 'FieldtypeOptions', 'backup_per_gb', 0, 'Backup Per GB', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(115, 'FieldtypeOptions', 'backup_per_device', 0, 'Backup Per Device', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(116, 'FieldtypeOptions', 'raid_health_hypers', 0, 'Raid Health-Hypers', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(117, 'FieldtypeOptions', 'bandwidth_process_hypers', 0, 'Bandwidth Process-Hypers', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(118, 'FieldtypeOptions', 'bandwidth_physical', 0, 'Bandwidth Physical', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(119, 'FieldtypeOptions', 'bandwidth_vps', 0, 'Bandwidth VPS', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(120, 'FieldtypeOptions', 'cancelation_requests', 0, 'Cancelation Requests', '{\"inputfieldClass\":\"InputfieldSelect\",\"collapsed\":0}'),
(121, 'FieldtypePage', 'employee_name', 0, 'Employee name', '{\"derefAsPage\":2,\"inputfield\":\"InputfieldSelect\",\"distinctAutojoin\":true,\"parent_id\":0,\"template_id\":3,\"labelFieldName\":\"title\",\"collapsed\":0}');

-- --------------------------------------------------------

--
-- Table structure for table `fieldtype_options`
--

CREATE TABLE `fieldtype_options` (
  `fields_id` int(10) UNSIGNED NOT NULL,
  `option_id` int(10) UNSIGNED NOT NULL,
  `title` text DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `fieldtype_options`
--

INSERT INTO `fieldtype_options` (`fields_id`, `option_id`, `title`, `value`, `sort`) VALUES
(101, 101, 'public', '', 0),
(101, 100, 'private', '', 1),
(111, 1, 'Done', '', 0),
(111, 2, 'Not Done', '', 1),
(115, 1, 'Done', '', 0),
(115, 2, 'Not Done', '', 1),
(114, 1, 'Done', '', 0),
(114, 2, 'Not Done', '', 1),
(113, 1, 'Done', '', 0),
(113, 2, 'Not Done', '', 1),
(118, 1, 'Done', '', 0),
(118, 2, 'Not Done', '', 1),
(117, 1, 'Done', '', 0),
(117, 2, 'Not Done', '', 1),
(119, 1, 'Done', '', 0),
(119, 2, 'Not Done', '', 1),
(120, 1, 'Done', '', 0),
(120, 2, 'Not Done', '', 1),
(112, 1, 'Done', '', 0),
(112, 2, 'Not Done', '', 1),
(116, 1, 'Done', '', 0),
(116, 2, 'Not Done', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `field_ac_input`
--

CREATE TABLE `field_ac_input` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_ac_input`
--

INSERT INTO `field_ac_input` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 1, 0),
(1157, 1, 0),
(1159, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_admin_theme`
--

CREATE TABLE `field_admin_theme` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_admin_theme`
--

INSERT INTO `field_admin_theme` (`pages_id`, `data`) VALUES
(41, 166);

-- --------------------------------------------------------

--
-- Table structure for table `field_backup_per_device`
--

CREATE TABLE `field_backup_per_device` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_backup_per_device`
--

INSERT INTO `field_backup_per_device` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 1, 0),
(1157, 1, 0),
(1159, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_backup_per_gb`
--

CREATE TABLE `field_backup_per_gb` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_backup_per_gb`
--

INSERT INTO `field_backup_per_gb` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 1, 0),
(1157, 1, 0),
(1159, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_backup_vps`
--

CREATE TABLE `field_backup_vps` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_backup_vps`
--

INSERT INTO `field_backup_vps` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 1, 0),
(1157, 2, 0),
(1159, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_bandwidth_physical`
--

CREATE TABLE `field_bandwidth_physical` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_bandwidth_physical`
--

INSERT INTO `field_bandwidth_physical` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 1, 0),
(1157, 1, 0),
(1159, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_bandwidth_process_hypers`
--

CREATE TABLE `field_bandwidth_process_hypers` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_bandwidth_process_hypers`
--

INSERT INTO `field_bandwidth_process_hypers` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 1, 0),
(1157, 1, 0),
(1159, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_bandwidth_vps`
--

CREATE TABLE `field_bandwidth_vps` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_bandwidth_vps`
--

INSERT INTO `field_bandwidth_vps` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 2, 0),
(1157, 1, 0),
(1159, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_cancelation_requests`
--

CREATE TABLE `field_cancelation_requests` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_cancelation_requests`
--

INSERT INTO `field_cancelation_requests` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 1, 0),
(1157, 1, 0),
(1159, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_course_category`
--

CREATE TABLE `field_course_category` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(11) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_course_category`
--

INSERT INTO `field_course_category` (`pages_id`, `data`, `sort`) VALUES
(1015, 1035, 0),
(1030, 1035, 0),
(1018, 1036, 0),
(1031, 1036, 0),
(1033, 1036, 0),
(1033, 1037, 1),
(1030, 1038, 1);

-- --------------------------------------------------------

--
-- Table structure for table `field_date`
--

CREATE TABLE `field_date` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_date`
--

INSERT INTO `field_date` (`pages_id`, `data`) VALUES
(1147, '2023-10-13 00:00:00'),
(1146, '2023-09-20 00:00:00'),
(1084, '2023-09-02 00:00:00'),
(1148, '2023-09-07 08:16:03'),
(1149, '2023-09-21 00:00:00'),
(1151, '2023-09-07 08:49:54'),
(1154, '2023-09-29 00:00:00'),
(1155, '2023-09-07 13:49:29'),
(1157, '2023-09-07 13:50:44'),
(1158, '2023-09-30 00:00:00'),
(1159, '2023-09-07 15:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `field_email`
--

CREATE TABLE `field_email` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` varchar(250) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_email`
--

INSERT INTO `field_email` (`pages_id`, `data`) VALUES
(41, ''),
(1152, 'arif1@nn.sa');

-- --------------------------------------------------------

--
-- Table structure for table `field_employee_name`
--

CREATE TABLE `field_employee_name` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(11) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_employee_name`
--

INSERT INTO `field_employee_name` (`pages_id`, `data`, `sort`) VALUES
(1084, 1053, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_form_edit_fields`
--

CREATE TABLE `field_form_edit_fields` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `field_form_visibility`
--

CREATE TABLE `field_form_visibility` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_form_visibility`
--

INSERT INTO `field_form_visibility` (`pages_id`, `data`, `sort`) VALUES
(1043, 101, 0),
(1084, 101, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_instructor`
--

CREATE TABLE `field_instructor` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(11) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_instructor`
--

INSERT INTO `field_instructor` (`pages_id`, `data`, `sort`) VALUES
(1015, 1026, 0),
(1015, 1027, 1),
(1015, 1028, 2);

-- --------------------------------------------------------

--
-- Table structure for table `field_is_featured`
--

CREATE TABLE `field_is_featured` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_is_featured`
--

INSERT INTO `field_is_featured` (`pages_id`, `data`) VALUES
(1030, 1),
(1018, 1),
(1015, 1);

-- --------------------------------------------------------

--
-- Table structure for table `field_page_body`
--

CREATE TABLE `field_page_body` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_page_body`
--

INSERT INTO `field_page_body` (`pages_id`, `data`) VALUES
(1016, '<h4 style=\"color:#ff0000;\">This page is from Processwire. please login for change.</h4>\n<p>EX-10.1 3 dlr-20200331xex10d1.htm EX-10.1</p>\n<p> </p>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<div style=\"width:100%;\">\n<div style=\"width:100%;\">\n<table style=\"border-collapse:collapse;width:100%;\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td style=\"width:269.75pt;padding:0pt 0pt 0pt 0pt;border:1pt none #D9D9D9;\" valign=\"top\">\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\"><img	src=\"/site/assets/files/1016/logo-bg.71x0-is.png\" alt=\"\" width=\"71\" height=\"69\" /></p>\n</td>\n<td style=\"width:269.75pt;padding:0pt 0pt 0pt 0pt;border:1pt none #D9D9D9;\" valign=\"top\">\n<p style=\"margin:3pt 0pt 0pt;text-align:right;color:#7f7f7f;font-family:\'Times New Roman\', Times, serif;font-size:7pt;\"><span style=\"font-family:Arial, Helvetica, sans-serif;color:#7f7f7f;font-size:7pt;\">Four Embarcadero Center, Suite 3200</span></p>\n<p style=\"margin:3pt 0pt 0pt;text-align:right;color:#7f7f7f;font-family:\'Times New Roman\', Times, serif;font-size:7pt;\"><span style=\"font-family:Arial, Helvetica, sans-serif;color:#7f7f7f;font-size:7pt;\">San Francisco, CA 94111</span></p>\n<p style=\"margin:3pt 0pt 0pt;text-align:right;color:#7f7f7f;font-family:\'Times New Roman\', Times, serif;font-size:7pt;\"><span style=\"font-family:Arial, Helvetica, sans-serif;color:#7f7f7f;font-size:7pt;\">Tel: +1 415 738 6500 </span></p>\n<p style=\"margin:3pt 0pt 0pt;text-align:right;font-family:\'Times New Roman\', Times, serif;font-size:7pt;\"><span style=\"font-family:Arial, Helvetica, sans-serif;color:#7f7f7f;font-size:7pt;\">www.digitalrealty.com</span></p>\n</td>\n</tr>\n</tbody>\n</table>\n</div>\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\"> </p>\n</div>\n</div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<p style=\"margin:0pt;text-align:right;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Exhibit 10.1</span></p>\n<p style=\"margin:0pt;text-align:right;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-size:12pt;\"> </span></p>\n<p style=\"margin:0pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">DIGITAL REALTY TRUST, INC.</span></p>\n<p style=\"margin:0pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">FOUR EMBARCADERO CENTER, SUITE 3200</span></p>\n<p style=\"margin:0pt 0pt 0.35pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">SAN FRANCISCO, CA 94111</span></p>\n<p style=\"margin:0pt 0pt 3.4pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-size:12pt;\"> </span></p>\n<p style=\"margin:0pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">November 19, 2018</span></p>\n<p style=\"margin:0pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-size:12pt;\"> </span></p>\n<p style=\"margin:0pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-size:12pt;\"> </span></p>\n<p style=\"margin:0pt 0pt 10pt;text-indent:36pt;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Re:  EMPLOYMENT TERMS</span></p>\n<p style=\"margin:0pt 0pt 10pt;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">Dear Greg:</span></p>\n<p style=\"margin:0pt 0pt 10pt;text-align:justify;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">Digital Realty Trust, Inc. (the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">REIT</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”) and DLR LLC (the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Employer</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”, and together with the REIT, the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Company</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”) are pleased to offer you employment with the REIT and the Employer on the terms and conditions set forth in this letter (the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Agreement</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”), effective as of January 1, 2019 (the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Effective Date</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”).</span></p>\n<p style=\"margin:0pt 0pt 10pt;text-indent:36pt;text-align:justify;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">1.</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">TERM.  </span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">Subject to the provisions for earlier termination hereinafter provided, your employment hereunder shall be for a term (the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Term</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”) commencing on the Effective Date and ending on the third (3rd) anniversary of the Effective Date (the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Initial Termination Date</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”).  If not previously terminated, the Term shall automatically be extended for one additional year on the Initial Termination Date unless either you or the Company elect not to so extend the Term by notifying the other party, in writing, of such election not less than sixty (60) days prior to the Initial Termination Date.</span></p>\n<p style=\"margin:0pt 0pt 10pt;text-indent:36pt;text-align:justify;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">2.</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">POSITION, DUTIES AND RESPONSIBILITIES.  </span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">During the Term, the Company will employ you, and you agree to be employed by the Company, as Executive Vice President, Chief Investment Officer of the REIT and the Employer.  In the capacity of Executive Vice President, Chief Investment Officer, you will have such duties and responsibilities as are normally associated with such position and will devote your full business time and attention to serving the Company in such position.  Your duties may be changed from time to time by the Company, consistent with your position.  You will report to the Chief Executive Officer of the Company.  You will work full-time at our offices located at 1 State Street in New York, New York (or such other location in the greater New York area as the Company may utilize as its offices), except for travel to other locations as may be necessary to fulfill your responsibilities.  At the Company’s request, you will serve the Company and/or its subsidiaries and affiliates in other offices and capacities in addition to the foregoing.  In the event that you serve in any one or more of such additional capacities, your compensation will not be increased beyond that specified in this Agreement.  In addition, in the event your service in one or more of such additional capacities is terminated, your compensation, as specified in this Agreement, will not be diminished or reduced in any manner as a result of such termination for so long as you otherwise remain employed under the terms of this Agreement.</span></p>\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"> </p>\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\"> </p>\n</div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<p><span style=\"font-size:xx-small;\"> </span></p>\n<div style=\"width:100%;\">\n<p style=\"margin:0pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\">1</p>\n</div>\n</div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<div style=\"background-color:#000000;clear:both;height:2pt;border:0;margin:30pt 0pt 30pt 0pt;\"> </div>\n</div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<div style=\"width:100%;\">\n<div style=\"width:100%;\">\n<table style=\"border-collapse:collapse;width:100%;\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td style=\"width:269.75pt;padding:0pt 0pt 0pt 0pt;border:1pt none #D9D9D9;\" valign=\"top\">\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\"><img style=\"width:1.4in;height:0.5961942in;\"	src=\"/processwire/page/edit/dlr-20200331xex10d1g001.jpg\" alt=\"Picture 6\" /></p>\n</td>\n<td style=\"width:269.75pt;padding:0pt 0pt 0pt 0pt;border:1pt none #D9D9D9;\" valign=\"top\">\n<p style=\"margin:3pt 0pt 0pt;text-align:right;color:#7f7f7f;font-family:\'Times New Roman\', Times, serif;font-size:7pt;\"><span style=\"font-family:Arial, Helvetica, sans-serif;color:#7f7f7f;font-size:7pt;\">Four Embarcadero Center, Suite 3200</span></p>\n<p style=\"margin:3pt 0pt 0pt;text-align:right;color:#7f7f7f;font-family:\'Times New Roman\', Times, serif;font-size:7pt;\"><span style=\"font-family:Arial, Helvetica, sans-serif;color:#7f7f7f;font-size:7pt;\">San Francisco, CA 94111</span></p>\n<p style=\"margin:3pt 0pt 0pt;text-align:right;color:#7f7f7f;font-family:\'Times New Roman\', Times, serif;font-size:7pt;\"><span style=\"font-family:Arial, Helvetica, sans-serif;color:#7f7f7f;font-size:7pt;\">Tel: +1 415 738 6500 </span></p>\n<p style=\"margin:3pt 0pt 0pt;text-align:right;font-family:\'Times New Roman\', Times, serif;font-size:7pt;\"><span style=\"font-family:Arial, Helvetica, sans-serif;color:#7f7f7f;font-size:7pt;\">www.digitalrealty.com</span></p>\n</td>\n</tr>\n</tbody>\n</table>\n</div>\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\"> </p>\n</div>\n</div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\"> </p>\n<p style=\"margin:0pt 0pt 10pt;text-indent:36pt;text-align:justify;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">3.</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">BASE COMPENSATION.  </span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">During the Term, the Company will pay you a base salary of $550,000 per year, less payroll deductions and all required withholdings, payable in accordance with the Company’s payroll practices and prorated for any partial month of employment.  Your annual base salary may be increased, but not decreased, by the Compensation Committee of the Board of Directors of the REIT (the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Compensation Committee</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”) in its discretion pursuant to the Company’s policies as in effect from time to time, and such increased amount thereafter will be your base salary per year for purposes of this Agreement.</span></p>\n<p style=\"margin:0pt 0pt 10pt;text-indent:36pt;text-align:justify;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">4.</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">ANNUAL BONUS.  </span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">In addition to the base salary set forth above, during the Term, commencing with calendar year 2019, you will be eligible to participate in the Company’s incentive bonus plan applicable to similarly situated executives of the Company.  The amount of your annual bonus will be based on the attainment of performance criteria established and evaluated by the Company in accordance with the terms of such bonus plan as in effect from time to time, provided that, subject to the terms of such bonus plan and attainment of performance criteria established by the Company, your target and maximum annual bonus shall be one hundred percent (100%) and two hundred percent (200%), respectively, of your base salary for such year.  Any annual bonus that becomes payable to you is intended to satisfy the short-term deferral exemption under Treasury Regulation Section 1.409A-1(b)(4) and shall be made not later than the last day of the applicable two and one-half (2½) month “short-term deferral period” with respect to such annual bonus, within the meaning of Treasury Regulation Section 1.409A-1(b)(4).</span></p>\n<p style=\"margin:0pt 0pt 10pt;text-indent:36pt;text-align:justify;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">5.</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">BENEFITS AND FLEXIBLE PAID TIME-OFF.  </span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">During the Term, you will be eligible to participate in all savings and retirement plans, practices, policies and programs maintained or sponsored by the Company from time to time which are applicable to other similarly situated executives of the Company, subject to the terms and conditions thereof.  During the Term, you will also be eligible for standard benefits, such as medical insurance, flexible paid time-off and holidays to the extent applicable generally to other similarly situated executives of the Company, subject to the terms and conditions of the applicable Company plans or policies.</span></p>\n<p style=\"margin:0pt 0pt 10pt;text-indent:36pt;text-align:justify;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">6.</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">LONG-TERM INCENTIVE AWARDS.  </span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">Subject to approval by the Compensation Committee and your continued employment with the Company through the grant date, the REIT agrees to grant to you in your capacity as an employee of the Company and in consideration of your provision of services to the Company (i) an award of profits interest units of Digital Realty Trust, L.P. (the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Operating Partnership</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”) equivalent to approximately $500,000 as of the date of grant, which will be subject to time-based vesting, and (ii) an award of Class D profits interest units of the Operating Partnership equivalent to approximately $1,500,000 as of the date of grant, which will be subject to performance-based vesting (collectively, the “</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-weight:bold;font-size:12pt;\">Grants</span><span style=\"font-family:\'Times New Roman\', Times, serif;font-size:12pt;\">”), each to be granted in 2020 at such time as annual awards of profits interest units and Class D profits interest units are made by the Company.  Alternatively, if you do not qualify as an accredited investor or if you otherwise so elect, you will receive (i) a restricted stock unit grant subject to time-based vesting in lieu of profits interest units and (ii) a restricted stock unit grant subject to performance-based vesting in lieu of the Class D profits interest units.  The number of profits interest units and Class D profits interest units (or, if applicable, restricted stock units) to be issued will be determined by the Compensation Committee in its discretion.  Subject to your continued service to the Company, twenty-five percent (25%) of the profits interest units (or, if applicable, restricted stock units) subject to the time-based Grant shall vest on each of the first four anniversaries of the date of grant or such other date as the Compensation Committee may</span></p>\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:12pt;\"> </p>\n<p style=\"margin:0pt;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\"> </p>\n</div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<p><span style=\"font-size:xx-small;\"> </span></p>\n<div style=\"width:100%;\">\n<p style=\"margin:0pt;text-align:center;font-family:\'Times New Roman\', Times, serif;font-size:10pt;\">2</p>\n</div>\n</div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\"> </div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<div style=\"width:100%;\"> </div>\n</div>\n<div style=\"margin-left:5.88235294117647%;margin-right:5.88235294117647%;\">\n<div style=\"background-color:#000000;clear:both;height:2pt;border:0;margin:30pt 0pt 30pt 0pt;\"> </div>\n</div>'),
(1024, '<hr />\n<h2>First featurette heading. It\'ll blow your mind.</h2>\n<p>Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>\n<p> </p>\n<hr />\n<h2>Oh yeah, it\'s that good. See for yourself.</h2>\n<p>Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>\n<p> </p>\n<hr />\n<h2>And lastly, this one. Checkmate.</h2>\n<p>Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>\n<p> </p>'),
(1030, '<ul>\n<li>.Inputfield:not(.InputfieldStateCollapsed)&gt; .InputfieldContent\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; display: flex; flex-wrap: wrap; list-style: none; background: none; width: 1600px; flex: 1 1 auto; color: rgb(53, 75, 96); font-family: Bangla858, -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, \"Noto Sans\", sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\", \"Noto Color Emoji\"; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"&gt;</li>\n<li> </li>\n<li>Choose File gif, jpg, jpeg, png drag and drop in new images above</li>\n<li>is FeaturedYesNo</li>\n<li>course category\n<ul>\n<li>Basic Course</li>\n<li>Advanced Course</li>\n<li>Networking Course</li>\n<li>Management Course</li>\n</ul>\n</li>\n<li>page_bodyEditViewInsertFormatTableToolsParagraph</li>\n</ul>'),
(1122, '<h5>Test 1</h5>\n<p>staff <br />phone: <a href=\"tel:00\">0000000000</a><br />email: <a href=\"mailto:%20abc@example.com\">abcc@dx.com</a></p>\n<hr />\n<h5>Test 2</h5>\n<p>Mobile No: <a href=\"tel:00\">0000000000</a><br />Email: <a href=\"mailto:%20abc@example.com\">abcc@dx.com</a></p>\n<hr />\n<h5>Test 3</h5>\n<p>Mobile No: <a href=\"tel:00\">0000000000</a><br />Email: <a href=\"mailto:%20abc@example.com\">abcc@dx.com</a></p>\n<hr />\n<h5>Test 4</h5>\n<p>Mobile No: <a href=\"tel:00\">0000000000</a><br />Email: <a href=\"mailto:%20abc@example.com\">abcc@dx.com</a></p>'),
(1127, '<p style=\"color:#808080;text-align:center;\">Completed Daily Duties Task!</p>'),
(1015, '<p> </p>\n<h1>Company rules and regulations</h1>\n<p>14.2 Matters not covered in this contract shall be subject to the national laws and regulations, Party A’s Employee Code of Conduct and other <strong>company rules and regulations</strong>. If any provision of this contract becomes invalid due to the revision of laws and regulations, the validity of other provisions in this contract will not be affected. The provisions of this contract that purport to survive the termination of the employment relationship between Party B and Party A shall continue to be effective after the termination of the employment relationship between Party B and Party A.</p>'),
(1018, '<h1>Company Policies</h1>'),
(1019, '<p>abc</p>');
INSERT INTO `field_page_body` (`pages_id`, `data`) VALUES
(1017, '<p>EX-10.15 4 pbyi-ex1015_150.htm EX-10.15</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:5pt;\"> </p>\n<p style=\"text-align:right;margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-weight:bold;font-size:10pt;font-family:\'Times New Roman\';font-style:normal;text-transform:none;font-variant:normal;\">Exhibit 10.15</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n<p style=\"text-align:center;margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:Calibri;font-size:11pt;font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"><img style=\"width:222px;height:80px;\" title=\"\"	src=\"/processwire/page/edit/g2018030921271978351555.jpg\" alt=\"\" /></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">December 8, 2017</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Douglas Hunt</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Via E-Mail</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Re: <span style=\"margin-left:41pt;\">EMPLOYMENT OFFER LETTER</span></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11.5pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Dear Douglas<span style=\"color:#4d4d4d;\">:</span></p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:10pt;text-indent:7.49%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Puma Biotechnology, Inc., a Delaware corporation (the \"Company\") is pleased to offer you the Full Time, Exempt position of Senior <span style=\"color:#3d3d3d;\">Vice </span>President, Regulatory Affairs of the Company, with terms as noted below. Please confirm your acceptance of this offer by signing and returning a copy of this letter on or before December 11, 2017:</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.85%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">1.<span style=\"margin-left:36pt;\">EFFECTIVE DATE, POSITION, DUTIES </span><span style=\"font-size:9pt;\">AND </span>RESPONSIBILITIES<span style=\"color:#626064;\">. </span>The terms will become effective on the date you start your employment (the \"Effective Date\"), which shall be no later than January 2, 2018. As of the Effective Date, the Company will employ you as its Senior Vice President, Regulatory Affairs. In such capacity, you will have such duties and responsibilities as are normally associated with such position. Your duties may be changed from time to time by the Company in its discretion. <span style=\"color:#3d3d3d;\">You </span>will report to the Chief Executive Officer or such other individual as the Company may designate, and will work at the Company\'s offices located in Los Angeles, California, or such other location as the Company may designate, except for travel to other locations as may be necessary to fulfill your responsibilities<span style=\"color:#0a0a0a;\">. </span>Although your initial title and duties are described above, the Company may assign you additional or different duties and/or titles from time-to-time<span style=\"color:#4d4d4d;\">.</span></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.49%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">2.<span style=\"margin-left:36pt;\">BASE COMPENSATION. During</span> your employment with the Company, the Company will pay you a base salary of $330,750 per year (the <span style=\"color:#3d3d3d;\">\"Base </span>Salary\"), less payroll deductions and all required withholdings, payable in installments in accordance with the Company\'s normal payroll practices (but in no event less often than monthly) and prorated for any partial pay period of employment. Your Base Salary may be subject to adjustment pursuant to the Company\'s policies as in effect from time to time.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.55%;color:#282828;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">3.<span style=\"font-size:10.5pt;\">ANNUAL </span>BONUS. In addition to the Base Salary set forth above, you will be eligible to receive an annual discretionary cash bonus (pro-rated for any partial year of service), based on the attainment of performance metrics and/or individual performance objectives, in each case, established and evaluated by the Company in its sole discretion (the \"Annual Bonus\"). Your target Annual Bonus shall be 30% of your Base Salary, but the actual amount of <span style=\"color:#262626;font-size:12pt;\">your Annual Bonus may be more or less (and may equal zero), depending on the attainment of applicable performance criteria. Payment of any Annual Bonus(es), to the extent any Annual Bonus(es) become payable, will be contingent upon your continued employment through the applicable payment date</span><span style=\"color:#444444;font-size:12pt;\">.</span></p>\n<p style=\"text-align:center;margin-top:12pt;margin-bottom:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">1</p>\n<hr style=\"width:100%;\" />\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.6%;color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">4.<span style=\"font-size:10pt;\">STOCK OPTION. </span>In connection with entering into this offer letter, following the commencement of your employment with the Company and provided that you are employed by the Company on the date of grant, the Company will grant you an option to purchase <span style=\"font-weight:bold;font-size:11pt;\">90,000 </span>shares of the Company\'s common stock (the <span style=\"font-weight:bold;font-size:11pt;\">\"Stock Option\") </span>at a per share exercise price equal to the Fair Market Value of a share of the Company\'s common stock on the date of grant as part of the Employment Inducement Pool. Subject to your continued employment with the Company through the applicable vesting date, <span style=\"font-size:10.5pt;\">l/3rd </span>of the shares underlying the Stock Option will vest on the first anniversary of the Effective Date and 1/36<span style=\"font-size:8.5pt;\">th </span>of the shares underlying the Stock Option will vest on each monthly anniversary of the Effective Date thereafter. Subject to the foregoing, the terms and conditions of the Stock Option will be set forth in a separate award agreement in such form as is prescribed by the Company, to be entered into by the Company and you.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.75%;color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">5.<span style=\"font-size:10pt;\">SIGNING BONUS. </span>In connection with entering into this offer letter, you will be paid a signing bonus to <span style=\"font-weight:bold;font-size:11pt;\">$40,000 </span>(the \"Signing Bonus\") within twenty days after the Effective Date. You and the Company acknowledge and agree that the Signing Bonus will not be earned in whole unless and until you are continuously, actively employed by the Company through the third anniversary of the Effective Date. <span style=\"font-size:11pt;\">If </span>your employment is terminated by the Company with Cause at any time prior to or on the first anniversary of the Effective Date, or by you for any reason prior to or on the first anniversary of the Effective Date, you will not be entitled to retain any portion of the Signing Bonus and you will be obligated to immediately repay to the Company the Signing Bonus<span style=\"color:#444444;\">, </span>in full, on the date of termination<span style=\"color:#444444;\">. </span>In the event that your employment is terminated by the Company with Cause or by you (a)after the first anniversary of the Effective Date but prior to or on the second anniversary of the Effective Date, the Company will allow you to retain 33% of the unearned bonus, and you hereby agree to repay to the Company, on the date of termination, 67% of the bonus; or (b) after the second anniversary of the Effective Date but prior to the third anniversary of the Effective Date, the Company will allow you to retain 67% of the unearned bonus, and you hereby agree to repay to the Company<span style=\"color:#444444;\">, </span>on the date of termination, 33% of the Signing Bonus. For purposes of this Section 5, <span style=\"font-weight:bold;font-size:11pt;\">Cause </span>shall mean: (1) your conv<span style=\"color:#444444;\">i</span>ction or plea of nolo contender to a misdemeanor involving moral turpitude or any felony, (2) your commission of any act of theft, embezzlement or misappropriation of Company assets, (3) your material breach of any agreement with the Company, (4) your failure to follow the reasonable and lawful written direction of any superior<span style=\"color:#444444;\">, </span>provided that you are given five days\' notice and opportunity to cure such failure, if curable, prior to termination, (5) your willful failure to perform the essential duties of your position, or (6) your commission of an act of unlawful discrimination, harassment or retaliation<span style=\"color:#0e0e0e;\">. </span>This does not alter the at-will nature of your employment.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:center;margin-top:12pt;margin-bottom:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">2</p>\n<hr style=\"width:100%;\" />\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.6%;color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">6.</span><span style=\"font-size:10pt;\">BENEFITS</span><span style=\"font-size:10pt;\"> </span><span style=\"font-size:10pt;\">AND VACATION</span><span style=\"color:#444444;font-size:10pt;\">.</span><span style=\"color:#444444;font-size:10pt;\"> </span><span style=\"color:#444444;font-size:10pt;\"> </span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">You will</span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">be eligible to</span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">participate in</span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">all health, welfare</span><span style=\"color:#444444;\">, </span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">savings and retirement plans</span><span style=\"color:#444444;\">, </span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">practices</span><span style=\"color:#444444;\">, </span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">policies and programs maintained or sponsored by the Company from time to time for the benefit of its similarly situated employees, subject to the terms and conditions thereof</span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">To the extent that you properly elect to participate in the</span><span style=\"color:#262626;font-size:12pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"font-size:11.5pt;\">Company\'s</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">applicable medical, dental and/or prescription benefit plans, the Company will pay the premiums for you and your dependents under such plans while you remain employed by the Company,</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-style:italic;\">provided, however, </span><span style=\"font-size:11.5pt;\">that</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">the</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">Company</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">shall</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">have</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">no</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">obligation</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">to</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">pay</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">any</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">such premiums if doing so would result in a violation of law and/or the imposition of penalty or excise taxes on the Company.</span><span style=\"font-size:11.5pt;\"> </span><span style=\"font-size:11.5pt;\">In addition, you will be eligible for other standard benefits, such as sick leave, vacations and holidays, in each case, to the extent available under, and in accordance with, Company policy applicable generally to other similarly situated employees of the Company. Notwithstanding the foregoing, nothing contained in this Section 6 shall, or shall be construed so as to, obligate the Company or its affiliates to adopt, sponsor, maintain or continue any benefit plans or programs at any time.</span></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.45%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">7.<span style=\"font-size:10pt;\">CONFIDENTIAL AND PROPRIETARY INFORMATION. </span>This offer of employment is contingent upon your execution of the Proprietary Information and Inventions Agreement, attached hereto as <span style=\"text-decoration:underline;\">Exhibit A.</span></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.65%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">8.<span style=\"font-size:10pt;\">NON-SOLICITATION. </span>You further agree that during the term of such employment and for one (1) year after your employment is terminated, you will not directly or indirectly solicit, <span style=\"color:#3d3d3d;\">induce, </span>or encourage any employee, consultant, agent, customer, vendor, or other parties doing business with the Company to terminate their employment, agency, or other relationship with the Company or to render services for or transfer their business from the Company and you will not initiate discussion with any such person for any such purpose or authorize or knowingly cooperate with the taking of any such actions by any other individual or entity.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.56%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">9.<span style=\"font-size:10pt;\">AT-WILL EMPLOYMENT; AMENDMENT. </span>Your employment with the Company is \"at-will,\" and either you or the Company may terminate your employment for any reason whatsoever (or for no reason) upon written notice of such termination to the other party. This at­ will employment relationship cannot be changed except in a writing signed by you and an authorized representative of the Company. This agreement may not be amended except by a signed writing executed by the parties hereto.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.65%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">10.<span style=\"font-size:10pt;\">COMPANY RULES AND REGULATIONS. </span>As an employee of the Company, you agree to abide by all Company rules, regulations and policies as set forth in the Company\'s employee handbook or as otherwise promulgated.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.81%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">11.<span style=\"font-size:10pt;\">WITHHOLDING. </span>The Company may withhold from any amounts payable under this offer letter such Federal, state, local or foreign taxes as shall be required to be withheld pursuant to any applicable law or regulation.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:center;margin-top:12pt;margin-bottom:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">3</p>\n<hr style=\"width:100%;\" />\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.7%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">12.</span><span style=\"font-size:10pt;\">ENTIRE AGREEMENT.</span><span style=\"font-size:10pt;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">As of the Effective Date, this offer letter, together with the Stock</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Option</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Agreement,</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Proprietary</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Information</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">and</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Inventions</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Agreement</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">and Relocation Costs Repayment</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Agreement,</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">comprises</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">the final, complete and exclusive agreement</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">between you and the Company with respect to the subject matter hereof and replaces and supersedes any and all other agreements, offers or promises, whether oral or written, made to you by any representative of the Company</span><span style=\"color:#5d5d5d;\">.</span><span style=\"color:#5d5d5d;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">You agree that any such agreement, offer or promise between you and any representative of the Company is hereby terminated and will be of no further force</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">or effect, and you acknowledge</span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"> </span><span style=\"color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">and agree that upon your execution of this offer letter, you will have no right or interest in or with respect to any such agreement, offer or promise.</span></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.64%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">13.<span style=\"font-size:10pt;\">CHOICE OF LAW. </span>This offer letter shall be interpreted and construed m accordance with California law without regard to any conflicts of laws principles.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.69%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">14.<span style=\"font-size:10pt;\">PROOF OF RIGHT TO WORK</span><span style=\"font-size:11pt;\">. </span>As required by law, this offer of employment is subject to satisfactory proof of your right to work in the United States.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.85%;color:#262626;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">15<span style=\"color:#464646;\">.</span><span style=\"font-size:10pt;\">BACKGROUND CHECK. </span>This offer of employment is expressly contingent upon your completion of a pre-employment background check conducted by an outside service bureau with results that are satisfactory to the Company in its sole discretion. Refusal to submit to the background check will result in your disqualification from further employment consideration. In addition, failure to successfully complete the background will cause this offer of employment to be withdrawn, or your employment to be terminated if you already have started work.</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:center;margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-style:italic;color:#262626;font-size:12.5pt;font-family:\'Times New Roman\';font-weight:normal;text-transform:none;font-variant:normal;\">[SIGNATURE PAGE FOLLOWS]</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12.5pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';\"> </p>\n<p style=\"text-align:center;margin-top:12pt;margin-bottom:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">4</p>\n<hr style=\"width:100%;\" />\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:11pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:5pt;\"> </p>\n<p style=\"text-align:center;margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:Calibri;font-size:11pt;font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\"><img style=\"width:199px;height:69px;\" title=\"\"	src=\"/processwire/page/edit/g2018030921271990151556.jpg\" alt=\"\" /></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;text-indent:7.46%;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Please confirm your agreement to the foregoing by signing and dating this offer letter in the space provided below for your signature and returning, as well as the attached Relocation Costs Repayment Agreement and returning both documents to the Company\'s Human Resources Department. Please retain one fully-executed copy for your files<span style=\"color:#444244;\">.</span></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:41.75%;text-indent:0%;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Sincerely<span style=\"color:#444244;\">,</span></p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:41.75%;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:41.75%;text-indent:-0.1%;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Puma Biotechnology<span style=\"color:#444244;\">, </span>Inc. a Delaware corporation</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:41.75%;text-indent:0%;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:41.75%;text-indent:0%;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">By<span style=\"color:#444244;\">: /s/ Alan Auerbach</span><span style=\"font-size:39pt;\"> </span></p>\n<p style=\"margin-bottom:0pt;margin-top:12pt;margin-left:41.75%;text-indent:0%;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Name<span style=\"color:#444244;\">: </span>Alan H. Auerbach</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:41.75%;text-indent:0%;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Title<span style=\"color:#444244;\">: </span>President and Chief Executive Officer</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<div>\n<table style=\"border-collapse:collapse;width:100%;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td style=\"width:50.07%;\"> </td>\n<td style=\"width:49.93%;\"> </td>\n</tr>\n<tr>\n<td valign=\"top\">\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:0pt;text-indent:0pt;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Accepted and Agreed,</p>\n</td>\n<td valign=\"top\">\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:0pt;text-indent:0pt;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n</td>\n</tr>\n<tr style=\"height:11.6pt;\">\n<td valign=\"top\">\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:0pt;text-indent:0pt;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">this 8<sup style=\"font-size:85%;vertical-align:top;\">th</sup> day of December , 2017</p>\n</td>\n<td valign=\"top\">\n<p style=\"margin-bottom:0pt;margin-top:0pt;margin-left:0pt;text-indent:0pt;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n</td>\n</tr>\n</tbody>\n</table>\n</div>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:12pt;\"> </p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:0pt;margin-left:44.99%;text-indent:-44.99%;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">By<span style=\"color:#444244;\">: /s/ Douglas Hunt</span></p>\n<p style=\"text-align:justify;margin-bottom:0pt;margin-top:6pt;margin-left:44.99%;text-indent:-44.99%;color:#262426;font-size:11.5pt;font-family:\'Times New Roman\';font-weight:normal;font-style:normal;text-transform:none;font-variant:normal;\">Name<span style=\"color:#444244;\">: </span>Douglas Hunt</p>\n<p style=\"margin-bottom:0pt;margin-top:0pt;text-indent:0%;font-family:\'Times New Roman\';font-size:10pt;\"> </p>\n<p style=\"margin-bottom:0pt;margin-top:12pt;text-indent:0%;font-size:0pt;\"> </p>');

-- --------------------------------------------------------

--
-- Table structure for table `field_page_images`
--

CREATE TABLE `field_page_images` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` varchar(250) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `filedata` mediumtext DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `created_users_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified_users_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `ratio` decimal(4,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_page_images`
--

INSERT INTO `field_page_images` (`pages_id`, `data`, `sort`, `description`, `modified`, `created`, `filedata`, `filesize`, `created_users_id`, `modified_users_id`, `width`, `height`, `ratio`) VALUES
(1016, 'logo-bg.png', 0, '', '2023-08-17 23:48:26', '2023-08-17 23:48:26', '', 13344, 41, 41, 320, 310, '1.03'),
(1024, '1svzkctrci8bwb0qpdozkbp0prhsoqzpl0wjs6y0.png', 0, '', '2023-08-18 17:22:14', '2023-08-18 17:22:14', '{\"uploadName\":\"1SvzKctRCi8bwB0QPdOZkBP0pRhsOqZpl0wjs6y0.png\"}', 20182, 41, 41, 915, 480, '1.91'),
(1015, '211356-programmer-life-748x468.jpg', 0, '', '2023-08-27 02:28:25', '2023-08-27 02:28:25', '', 9343, 41, 41, 748, 468, '1.60'),
(1127, 'electric.jpg', 0, '', '2023-09-07 10:41:46', '2023-09-07 10:41:46', '', 14510, 41, 41, 352, 484, '0.73');

-- --------------------------------------------------------

--
-- Table structure for table `field_pass`
--

CREATE TABLE `field_pass` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` char(40) NOT NULL,
  `salt` char(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

--
-- Dumping data for table `field_pass`
--

INSERT INTO `field_pass` (`pages_id`, `data`, `salt`) VALUES
(41, 'XHdzuOxj/naEqE.nDf46L4ZyI7lKCX6', '$2y$11$ucu9mgpuui9r.uyrQHF3ku'),
(40, '', ''),
(1053, 'n6RHxRzXG9ylTMKfLmXcACqwpPCVtky', '$2y$11$PTq2TrdsECNfB7m/hX6QJO'),
(1152, 'PGmf/VsaGGfS7krlFJCkMtaV6HAQbAu', '$2y$11$KnSjqcEx6mHegTOAoMf3ee');

-- --------------------------------------------------------

--
-- Table structure for table `field_permissions`
--

CREATE TABLE `field_permissions` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(11) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_permissions`
--

INSERT INTO `field_permissions` (`pages_id`, `data`, `sort`) VALUES
(38, 32, 1),
(38, 34, 2),
(38, 35, 3),
(37, 36, 0),
(38, 36, 0),
(38, 50, 4),
(38, 51, 5),
(38, 52, 7),
(38, 53, 8),
(38, 54, 6);

-- --------------------------------------------------------

--
-- Table structure for table `field_process`
--

CREATE TABLE `field_process` (
  `pages_id` int(11) NOT NULL DEFAULT 0,
  `data` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_process`
--

INSERT INTO `field_process` (`pages_id`, `data`) VALUES
(6, 17),
(3, 12),
(8, 12),
(9, 14),
(10, 7),
(11, 47),
(16, 48),
(300, 104),
(21, 50),
(29, 66),
(23, 10),
(304, 138),
(31, 136),
(22, 76),
(30, 68),
(303, 129),
(2, 87),
(302, 121),
(301, 109),
(28, 76),
(1007, 150),
(1010, 165),
(1012, 167),
(1163, 180);

-- --------------------------------------------------------

--
-- Table structure for table `field_profile_photo`
--

CREATE TABLE `field_profile_photo` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` varchar(250) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `filedata` mediumtext DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `created_users_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified_users_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `ratio` decimal(4,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_profile_photo`
--

INSERT INTO `field_profile_photo` (`pages_id`, `data`, `sort`, `description`, `modified`, `created`, `filedata`, `filesize`, `created_users_id`, `modified_users_id`, `width`, `height`, `ratio`) VALUES
(1027, 'mr-ak-sharma.jpg', 0, '', '2023-08-18 16:38:50', '2023-08-18 16:38:50', '', 118036, 41, 41, 750, 512, '1.46'),
(1028, 'depositphotos_4032122-stock-photo-confident-teacher.jpg', 0, '', '2023-08-18 16:39:09', '2023-08-18 16:39:09', '', 92448, 41, 41, 1024, 768, '1.33'),
(1026, 'pexels-oleksandr-pidvalnyi-1172207.jpg', 0, '', '2023-08-27 02:49:38', '2023-08-27 02:49:38', '', 3129174, 41, 41, 4256, 2832, '1.50');

-- --------------------------------------------------------

--
-- Table structure for table `field_raid_health_hypers`
--

CREATE TABLE `field_raid_health_hypers` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_raid_health_hypers`
--

INSERT INTO `field_raid_health_hypers` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 2, 0),
(1157, 2, 0),
(1159, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_roles`
--

CREATE TABLE `field_roles` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(11) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_roles`
--

INSERT INTO `field_roles` (`pages_id`, `data`, `sort`) VALUES
(40, 37, 0),
(41, 37, 0),
(1053, 37, 0),
(1152, 37, 0),
(41, 38, 2);

-- --------------------------------------------------------

--
-- Table structure for table `field_room_alert`
--

CREATE TABLE `field_room_alert` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_room_alert`
--

INSERT INTO `field_room_alert` (`pages_id`, `data`, `sort`) VALUES
(1148, 1, 0),
(1151, 1, 0),
(1155, 1, 0),
(1157, 1, 0),
(1159, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `field_short_description`
--

CREATE TABLE `field_short_description` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_short_description`
--

INSERT INTO `field_short_description` (`pages_id`, `data`) VALUES
(1084, 'If you change Generator today, Please choose the date and write \"Done\" and save!'),
(1154, 'Done'),
(1020, 'Please complete your daily task to visit this page!'),
(1158, 'Done!'),
(1018, 'This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.'),
(1015, 'This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.'),
(1024, 'You will find NashirNet all course in one place.'),
(1159, 'ddnknknkgnf'),
(1026, 'Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.'),
(1027, 'Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.'),
(1028, 'Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.'),
(1030, 'Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit'),
(1043, 'Please see the form and fill it up what you have done today!'),
(1155, 'Done!'),
(1157, 'Done2!'),
(1031, 'Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.'),
(1033, 'Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.'),
(1032, 'This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information'),
(1038, 'Management Course Management Course Management Course Management Course'),
(1037, 'Networking Course  Networking Course  Networking Course  Networking Course  Networking Course'),
(1035, 'Basic Course Basic Course Basic Course Basic Course Basic Course Basic Course Basic Course'),
(1036, 'Advanced Course Advanced Course Advanced Course Advanced Course Advanced Course'),
(1146, 'abc'),
(1148, 'wwwwwwwwww'),
(1149, 'Done'),
(1151, 'xxxx');

-- --------------------------------------------------------

--
-- Table structure for table `field_thumbnail`
--

CREATE TABLE `field_thumbnail` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` varchar(250) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `filedata` mediumtext DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `created_users_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified_users_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `ratio` decimal(4,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_thumbnail`
--

INSERT INTO `field_thumbnail` (`pages_id`, `data`, `sort`, `description`, `modified`, `created`, `filedata`, `filesize`, `created_users_id`, `modified_users_id`, `width`, `height`, `ratio`) VALUES
(1031, 'ongoing-training-and-development-banner.jpg', 0, '', '2023-08-18 17:30:21', '2023-08-18 17:30:21', '{\"uploadName\":\"Ongoing-training-and-development-banner.jpg\"}', 28288, 41, 41, 940, 278, '3.38'),
(1033, 'training-banner-1-768x204.png', 0, '', '2023-08-22 22:09:50', '2023-08-22 22:09:50', '{\"uploadName\":\"Training-Banner-1-768x204.png\"}', 73776, 41, 41, 768, 204, '3.76'),
(1015, 'servers22-1.jpg', 0, '', '2023-08-27 02:30:00', '2023-08-27 02:30:00', '{\"uploadName\":\"Servers22-1.jpg\"}', 281126, 41, 41, 1920, 1080, '1.78'),
(1038, 'mqdefault.jpg', 0, '', '2023-08-23 00:03:03', '2023-08-23 00:03:03', '', 4610, 41, 41, 320, 180, '1.78'),
(1037, 'servers22-1.jpg', 0, '', '2023-08-23 00:07:52', '2023-08-23 00:07:52', '{\"uploadName\":\"Servers22-1.jpg\"}', 281126, 41, 41, 1920, 1080, '1.78'),
(1035, 'logo-bg.png', 0, '', '2023-08-23 00:08:31', '2023-08-23 00:08:31', '', 13344, 41, 41, 320, 310, '1.03'),
(1036, 'college-study-web-development-2.png', 0, '', '2023-08-23 00:09:22', '2023-08-23 00:09:22', '', 84990, 41, 41, 1238, 800, '1.55'),
(1043, 'form_filling_2022.jpg', 0, '', '2023-08-30 07:12:24', '2023-08-30 07:12:24', '{\"uploadName\":\"Form Filling 2022.jpg\"}', 30409, 41, 41, 800, 400, '2.00'),
(1030, 'colour-math-function-1170167.jpg', 0, '', '2023-08-27 02:30:42', '2023-08-27 02:30:41', '{\"uploadName\":\"Training-Banner-1-768x204.png\"}', 598056, 41, 41, 2048, 1536, '1.33'),
(1018, 'pexels-akash-sarkar-6132116.jpg', 0, '', '2023-08-27 02:31:16', '2023-08-27 02:31:16', '{\"uploadName\":\"joshua-hanson-FCcNHcylc9o-unsplash.jpg\"}', 1081745, 41, 41, 2576, 1717, '1.50'),
(1084, 'backup-power-generators.jpg', 0, '', '2023-09-07 13:39:24', '2023-09-07 13:39:24', '{\"uploadName\":\"forms.png\"}', 178180, 41, 41, 1890, 1080, '1.75');

-- --------------------------------------------------------

--
-- Table structure for table `field_title`
--

CREATE TABLE `field_title` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_title`
--

INSERT INTO `field_title` (`pages_id`, `data`) VALUES
(11, 'Templates'),
(16, 'Fields'),
(22, 'Setup'),
(3, 'Pages'),
(6, 'Add Page'),
(8, 'Tree'),
(9, 'Save Sort'),
(10, 'Edit'),
(21, 'Modules'),
(29, 'Users'),
(30, 'Roles'),
(2, 'Admin'),
(7, 'Trash'),
(27, '404 Not Found'),
(302, 'Insert Link'),
(23, 'Login'),
(304, 'Profile'),
(301, 'Empty Trash'),
(300, 'Search'),
(303, 'Insert Image'),
(28, 'Access'),
(31, 'Permissions'),
(32, 'Edit pages'),
(34, 'Delete pages'),
(35, 'Move pages (change parent)'),
(36, 'View pages'),
(50, 'Sort child pages'),
(51, 'Change templates on pages'),
(52, 'Administer users'),
(53, 'User can update profile/password'),
(54, 'Lock or unlock a page'),
(1, 'Home'),
(1006, 'Use Page Lister'),
(1007, 'Find'),
(1010, 'Recent'),
(1011, 'Can see recently edited pages'),
(1012, 'Logs'),
(1013, 'Can view system logs'),
(1014, 'Can manage system logs'),
(1015, 'Company Rules and Regulations'),
(1016, 'Rules & Regulations For The Employees'),
(1017, 'Rules & Regulations For The Customers'),
(1018, 'Company Policies Course'),
(1019, 'Employee code of conduct & Ethics policy.'),
(1020, 'Daily Tasks'),
(1024, 'Courses'),
(1025, 'Instructors'),
(1026, 'Rahat Arif'),
(1027, 'Muhammad Ali'),
(1028, 'Jhon Smith'),
(1029, 'Course List'),
(1030, 'Basic Employee Training'),
(1031, 'Market Growth Course'),
(1032, 'All Courses'),
(1033, 'Advanced Networking Course'),
(1034, 'Course categories'),
(1035, 'Basic Courses'),
(1036, 'Advanced Course'),
(1037, 'Networking Courses'),
(1038, 'Management Courses'),
(1039, 'Basic Employee Training Class One'),
(1040, 'Advanced Networking Course Class One'),
(1041, 'Market Growth Course Class One'),
(1042, 'Use the front-end page editor'),
(1043, 'Daily Duties'),
(1044, 'Profile Page'),
(1046, 'Login'),
(1129, 'Generator Portal List'),
(1127, 'Entry of Daily Duties'),
(1126, 'Form Page'),
(1145, 'admin'),
(1146, 'admin  -  06-09-2023 20:59:00'),
(1122, 'Emergency Numbers'),
(1123, 'admin'),
(1084, 'Generator Portal'),
(1147, 'admin  -  06-09-2023 20:59:08'),
(1148, 'admin  -  07-09-2023 08:16:03'),
(1149, 'admin  -  07-09-2023 08:19:51'),
(1150, 'staff_test'),
(1151, 'staff_test  -  07-09-2023 08:49:54'),
(1153, 'staff_test_2'),
(1154, 'staff_test_2  -  07-09-2023 13:43:21'),
(1155, 'admin  -  07-09-2023 13:49:29'),
(1156, 'staff_test_2'),
(1157, 'staff_test_2  -  07-09-2023 13:50:44'),
(1158, 'admin  -  07-09-2023 14:56:14'),
(1159, 'admin  -  07-09-2023 15:03:23'),
(1160, 'Form Builder'),
(1161, 'Access Form Builder admin page'),
(1162, 'Add new or import Form Builder forms'),
(1163, 'Forms'),
(1164, 'sss');

-- --------------------------------------------------------

--
-- Table structure for table `field_user_id`
--

CREATE TABLE `field_user_id` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `data` int(11) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `field_user_id`
--

INSERT INTO `field_user_id` (`pages_id`, `data`, `sort`) VALUES
(1123, 41, 0),
(1145, 41, 0),
(1146, 41, 0),
(1147, 41, 0),
(1148, 41, 0),
(1149, 41, 0),
(1155, 41, 0),
(1158, 41, 0),
(1159, 41, 0),
(1084, 1053, 0),
(1150, 1053, 0),
(1151, 1053, 0),
(1153, 1152, 0),
(1154, 1152, 0),
(1156, 1152, 0),
(1157, 1152, 0);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `data` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `data`) VALUES
(1, 'test_form', '{\"required\":false,\"columnWidth\":0,\"action\":\".\\/\",\"method\":\"post\",\"roles\":{\"form-submit\":[\"guest\"],\"form-list\":[],\"form-edit\":[],\"form-delete\":[],\"entries-list\":[],\"entries-edit\":[],\"entries-delete\":[],\"entries-page\":[],\"entries-resend\":[]},\"flags\":0,\"pluginActions\":[],\"framework\":\"Basic\",\"allowPreset\":0,\"skipSessionKey\":0,\"useCookies\":0,\"submitText\":\"Submit\",\"successMessage\":\"Thank you, your form has been submitted.\",\"errorMessage\":\"One or more errors prevented submission of the form. Please correct and try again.\",\"mobilePx\":0,\"frBasic_noLoad\":[],\"frBasic_cssURL\":\"\\/site\\/modules\\/FormBuilder\\/frameworks\\/basic\\/main.css\",\"frBasic_itemContent\":[\"description\",\"out\",\"error\",\"notes\"],\"listFields\":[],\"entryDays\":0,\"emailSubject\":\"Form Submission\",\"emailFiles\":0,\"responderSubject\":\"Auto-Response\",\"saveFlags\":1,\"children\":{\"checkbox_test\":{\"type\":\"Checkbox\",\"label\":\"Checkbox Test\",\"description\":\"This is a test Formbuilder\",\"required\":false,\"columnWidth\":0,\"collapsed\":\"0\",\"checkedValue\":\"1\"},\"date_time\":{\"type\":\"Datetime\",\"label\":\"Date Time\",\"description\":\"This is test Check form Builder\",\"columnWidth\":0,\"collapsed\":\"0\",\"inputType\":\"text\",\"htmlType\":\"date\",\"dateSelectFormat\":\"yMd\",\"yearFrom\":1923,\"yearTo\":2043,\"yearLock\":0,\"datepicker\":\"0\",\"timeInputSelect\":0,\"dateInputFormat\":\"Y-m-d\",\"size\":25}}}');

-- --------------------------------------------------------

--
-- Table structure for table `forms_entries`
--

CREATE TABLE `forms_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `forms_id` int(10) UNSIGNED NOT NULL,
  `flags` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `str` varchar(128) NOT NULL DEFAULT '',
  `data` mediumtext NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `forms_entries`
--

INSERT INTO `forms_entries` (`id`, `forms_id`, `flags`, `str`, `data`, `created`, `modified`) VALUES
(1, 1, 0, '', '{\"checkbox_test\":\"1\",\"date_time\":false}', '2023-09-10 11:01:25', '2023-09-10 08:01:25'),
(2, 1, 0, '', '{\"checkbox_test\":\"1\",\"date_time\":false}', '2023-09-10 12:34:36', '2023-09-10 09:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `class` varchar(128) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `flags` int(11) NOT NULL DEFAULT 0,
  `data` mediumtext NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `class`, `flags`, `data`, `created`) VALUES
(1, 'FieldtypeTextarea', 0, '', '2023-08-17 21:02:04'),
(3, 'FieldtypeText', 0, '', '2023-08-17 21:02:04'),
(4, 'FieldtypePage', 0, '', '2023-08-17 21:02:04'),
(30, 'InputfieldForm', 0, '', '2023-08-17 21:02:04'),
(6, 'FieldtypeFile', 0, '', '2023-08-17 21:02:04'),
(7, 'ProcessPageEdit', 1, '', '2023-08-17 21:02:04'),
(10, 'ProcessLogin', 0, '', '2023-08-17 21:02:04'),
(12, 'ProcessPageList', 0, '{\"pageLabelField\":\"title\",\"paginationLimit\":25,\"limit\":50}', '2023-08-17 21:02:04'),
(121, 'ProcessPageEditLink', 1, '', '2023-08-17 21:02:04'),
(14, 'ProcessPageSort', 0, '', '2023-08-17 21:02:04'),
(15, 'InputfieldPageListSelect', 0, '', '2023-08-17 21:02:04'),
(117, 'JqueryUI', 1, '', '2023-08-17 21:02:04'),
(17, 'ProcessPageAdd', 0, '', '2023-08-17 21:02:04'),
(125, 'SessionLoginThrottle', 11, '', '2023-08-17 21:02:04'),
(122, 'InputfieldPassword', 0, '', '2023-08-17 21:02:04'),
(25, 'InputfieldAsmSelect', 0, '', '2023-08-17 21:02:04'),
(116, 'JqueryCore', 1, '', '2023-08-17 21:02:04'),
(27, 'FieldtypeModule', 0, '', '2023-08-17 21:02:04'),
(28, 'FieldtypeDatetime', 0, '', '2023-08-17 21:02:04'),
(29, 'FieldtypeEmail', 0, '', '2023-08-17 21:02:04'),
(108, 'InputfieldURL', 0, '', '2023-08-17 21:02:04'),
(32, 'InputfieldSubmit', 0, '', '2023-08-17 21:02:04'),
(34, 'InputfieldText', 0, '', '2023-08-17 21:02:04'),
(35, 'InputfieldTextarea', 0, '', '2023-08-17 21:02:04'),
(36, 'InputfieldSelect', 0, '', '2023-08-17 21:02:04'),
(37, 'InputfieldCheckbox', 0, '', '2023-08-17 21:02:04'),
(38, 'InputfieldCheckboxes', 0, '', '2023-08-17 21:02:04'),
(39, 'InputfieldRadios', 0, '', '2023-08-17 21:02:04'),
(40, 'InputfieldHidden', 0, '', '2023-08-17 21:02:04'),
(41, 'InputfieldName', 0, '', '2023-08-17 21:02:04'),
(43, 'InputfieldSelectMultiple', 0, '', '2023-08-17 21:02:04'),
(45, 'JqueryWireTabs', 0, '', '2023-08-17 21:02:04'),
(47, 'ProcessTemplate', 0, '', '2023-08-17 21:02:04'),
(48, 'ProcessField', 32, '', '2023-08-17 21:02:04'),
(50, 'ProcessModule', 0, '', '2023-08-17 21:02:04'),
(114, 'PagePermissions', 3, '', '2023-08-17 21:02:04'),
(97, 'FieldtypeCheckbox', 1, '', '2023-08-17 21:02:04'),
(115, 'PageRender', 3, '{\"clearCache\":1}', '2023-08-17 21:02:04'),
(55, 'InputfieldFile', 0, '', '2023-08-17 21:02:04'),
(56, 'InputfieldImage', 0, '', '2023-08-17 21:02:04'),
(57, 'FieldtypeImage', 0, '', '2023-08-17 21:02:04'),
(60, 'InputfieldPage', 0, '{\"inputfieldClasses\":[\"InputfieldSelect\",\"InputfieldSelectMultiple\",\"InputfieldCheckboxes\",\"InputfieldRadios\",\"InputfieldAsmSelect\",\"InputfieldPageListSelect\",\"InputfieldPageListSelectMultiple\",\"InputfieldPageAutocomplete\"]}', '2023-08-17 21:02:04'),
(61, 'TextformatterEntities', 0, '', '2023-08-17 21:02:04'),
(66, 'ProcessUser', 0, '{\"showFields\":[\"name\",\"email\",\"roles\"]}', '2023-08-17 21:02:04'),
(67, 'MarkupAdminDataTable', 0, '', '2023-08-17 21:02:04'),
(68, 'ProcessRole', 0, '{\"showFields\":[\"name\"]}', '2023-08-17 21:02:04'),
(76, 'ProcessList', 0, '', '2023-08-17 21:02:04'),
(78, 'InputfieldFieldset', 0, '', '2023-08-17 21:02:04'),
(79, 'InputfieldMarkup', 0, '', '2023-08-17 21:02:04'),
(80, 'InputfieldEmail', 0, '', '2023-08-17 21:02:04'),
(89, 'FieldtypeFloat', 1, '', '2023-08-17 21:02:04'),
(83, 'ProcessPageView', 0, '', '2023-08-17 21:02:04'),
(84, 'FieldtypeInteger', 0, '', '2023-08-17 21:02:04'),
(85, 'InputfieldInteger', 0, '', '2023-08-17 21:02:04'),
(86, 'InputfieldPageName', 0, '', '2023-08-17 21:02:04'),
(87, 'ProcessHome', 0, '', '2023-08-17 21:02:04'),
(90, 'InputfieldFloat', 0, '', '2023-08-17 21:02:04'),
(94, 'InputfieldDatetime', 0, '', '2023-08-17 21:02:04'),
(98, 'MarkupPagerNav', 0, '', '2023-08-17 21:02:04'),
(129, 'ProcessPageEditImageSelect', 1, '', '2023-08-17 21:02:04'),
(103, 'JqueryTableSorter', 1, '', '2023-08-17 21:02:04'),
(104, 'ProcessPageSearch', 1, '{\"searchFields\":\"title\",\"displayField\":\"title path\"}', '2023-08-17 21:02:04'),
(105, 'FieldtypeFieldsetOpen', 1, '', '2023-08-17 21:02:04'),
(106, 'FieldtypeFieldsetClose', 1, '', '2023-08-17 21:02:04'),
(107, 'FieldtypeFieldsetTabOpen', 1, '', '2023-08-17 21:02:04'),
(109, 'ProcessPageTrash', 1, '', '2023-08-17 21:02:04'),
(111, 'FieldtypePageTitle', 1, '', '2023-08-17 21:02:04'),
(112, 'InputfieldPageTitle', 0, '', '2023-08-17 21:02:04'),
(113, 'MarkupPageArray', 3, '', '2023-08-17 21:02:04'),
(131, 'InputfieldButton', 0, '', '2023-08-17 21:02:04'),
(133, 'FieldtypePassword', 1, '', '2023-08-17 21:02:04'),
(134, 'ProcessPageType', 33, '{\"showFields\":[]}', '2023-08-17 21:02:04'),
(135, 'FieldtypeURL', 1, '', '2023-08-17 21:02:04'),
(136, 'ProcessPermission', 1, '{\"showFields\":[\"name\",\"title\"]}', '2023-08-17 21:02:04'),
(137, 'InputfieldPageListSelectMultiple', 0, '', '2023-08-17 21:02:04'),
(138, 'ProcessProfile', 1, '{\"profileFields\":[\"name\",\"admin_theme\",\"email\",\"pass\"]}', '2023-08-17 21:02:04'),
(139, 'SystemUpdater', 1, '{\"systemVersion\":20,\"coreVersion\":\"3.0.224\"}', '2023-08-17 21:02:04'),
(148, 'AdminThemeDefault', 10, '{\"colors\":\"modern\"}', '2023-08-17 21:02:04'),
(149, 'InputfieldSelector', 42, '', '2023-08-17 21:02:04'),
(150, 'ProcessPageLister', 32, '', '2023-08-17 21:02:04'),
(151, 'JqueryMagnific', 1, '', '2023-08-17 21:02:04'),
(155, 'InputfieldTinyMCE', 0, '', '2023-08-17 21:02:04'),
(156, 'MarkupHTMLPurifier', 0, '', '2023-08-17 21:02:04'),
(159, '.Modules.wire/modules/', 8192, 'AdminTheme/AdminThemeDefault/AdminThemeDefault.module\nAdminTheme/AdminThemeReno/AdminThemeReno.module\nAdminTheme/AdminThemeUikit/AdminThemeUikit.module\nFieldtype/FieldtypeCache.module\nFieldtype/FieldtypeCheckbox.module\nFieldtype/FieldtypeComments/CommentFilterAkismet.module\nFieldtype/FieldtypeComments/FieldtypeComments.module\nFieldtype/FieldtypeComments/InputfieldCommentsAdmin.module\nFieldtype/FieldtypeDatetime.module\nFieldtype/FieldtypeDecimal.module\nFieldtype/FieldtypeEmail.module\nFieldtype/FieldtypeFieldsetClose.module\nFieldtype/FieldtypeFieldsetOpen.module\nFieldtype/FieldtypeFieldsetTabOpen.module\nFieldtype/FieldtypeFile/FieldtypeFile.module\nFieldtype/FieldtypeFloat.module\nFieldtype/FieldtypeImage/FieldtypeImage.module\nFieldtype/FieldtypeInteger.module\nFieldtype/FieldtypeModule.module\nFieldtype/FieldtypeOptions/FieldtypeOptions.module\nFieldtype/FieldtypePage.module\nFieldtype/FieldtypePageTable.module\nFieldtype/FieldtypePageTitle.module\nFieldtype/FieldtypePassword.module\nFieldtype/FieldtypeRepeater/FieldtypeFieldsetPage.module\nFieldtype/FieldtypeRepeater/FieldtypeRepeater.module\nFieldtype/FieldtypeRepeater/InputfieldRepeater.module\nFieldtype/FieldtypeSelector.module\nFieldtype/FieldtypeText.module\nFieldtype/FieldtypeTextarea.module\nFieldtype/FieldtypeToggle.module\nFieldtype/FieldtypeURL.module\nFileCompilerTags.module\nImage/ImageSizerEngineAnimatedGif/ImageSizerEngineAnimatedGif.module\nImage/ImageSizerEngineIMagick/ImageSizerEngineIMagick.module\nInputfield/InputfieldAsmSelect/InputfieldAsmSelect.module\nInputfield/InputfieldButton.module\nInputfield/InputfieldCheckbox/InputfieldCheckbox.module\nInputfield/InputfieldCheckboxes/InputfieldCheckboxes.module\nInputfield/InputfieldCKEditor/InputfieldCKEditor.module\nInputfield/InputfieldDatetime/InputfieldDatetime.module\nInputfield/InputfieldEmail.module\nInputfield/InputfieldFieldset.module\nInputfield/InputfieldFile/InputfieldFile.module\nInputfield/InputfieldFloat.module\nInputfield/InputfieldForm.module\nInputfield/InputfieldHidden.module\nInputfield/InputfieldIcon/InputfieldIcon.module\nInputfield/InputfieldImage/InputfieldImage.module\nInputfield/InputfieldInteger.module\nInputfield/InputfieldMarkup.module\nInputfield/InputfieldName.module\nInputfield/InputfieldPage/InputfieldPage.module\nInputfield/InputfieldPageAutocomplete/InputfieldPageAutocomplete.module\nInputfield/InputfieldPageListSelect/InputfieldPageListSelect.module\nInputfield/InputfieldPageListSelect/InputfieldPageListSelectMultiple.module\nInputfield/InputfieldPageName/InputfieldPageName.module\nInputfield/InputfieldPageTable/InputfieldPageTable.module\nInputfield/InputfieldPageTitle/InputfieldPageTitle.module\nInputfield/InputfieldPassword/InputfieldPassword.module\nInputfield/InputfieldRadios/InputfieldRadios.module\nInputfield/InputfieldSelect.module\nInputfield/InputfieldSelectMultiple.module\nInputfield/InputfieldSelector/InputfieldSelector.module\nInputfield/InputfieldSubmit/InputfieldSubmit.module\nInputfield/InputfieldText/InputfieldText.module\nInputfield/InputfieldTextarea.module\nInputfield/InputfieldTextTags/InputfieldTextTags.module\nInputfield/InputfieldTinyMCE/InputfieldTinyMCE.module.php\nInputfield/InputfieldToggle/InputfieldToggle.module\nInputfield/InputfieldURL.module\nJquery/JqueryCore/JqueryCore.module\nJquery/JqueryMagnific/JqueryMagnific.module\nJquery/JqueryTableSorter/JqueryTableSorter.module\nJquery/JqueryUI/JqueryUI.module\nJquery/JqueryWireTabs/JqueryWireTabs.module\nLanguageSupport/FieldtypePageTitleLanguage.module\nLanguageSupport/FieldtypeTextareaLanguage.module\nLanguageSupport/FieldtypeTextLanguage.module\nLanguageSupport/LanguageSupport.module\nLanguageSupport/LanguageSupportFields.module\nLanguageSupport/LanguageSupportPageNames.module\nLanguageSupport/LanguageTabs.module\nLanguageSupport/ProcessLanguage.module\nLanguageSupport/ProcessLanguageTranslator.module\nLazyCron.module\nMarkup/MarkupAdminDataTable/MarkupAdminDataTable.module\nMarkup/MarkupCache.module\nMarkup/MarkupHTMLPurifier/MarkupHTMLPurifier.module\nMarkup/MarkupPageArray.module\nMarkup/MarkupPageFields.module\nMarkup/MarkupPagerNav/MarkupPagerNav.module\nMarkup/MarkupRSS.module\nPage/PageFrontEdit/PageFrontEdit.module\nPagePathHistory.module\nPagePaths.module\nPagePermissions.module\nPageRender.module\nProcess/ProcessCommentsManager/ProcessCommentsManager.module\nProcess/ProcessField/ProcessField.module\nProcess/ProcessForgotPassword/ProcessForgotPassword.module\nProcess/ProcessHome.module\nProcess/ProcessList.module\nProcess/ProcessLogger/ProcessLogger.module\nProcess/ProcessLogin/ProcessLogin.module\nProcess/ProcessModule/ProcessModule.module\nProcess/ProcessPageAdd/ProcessPageAdd.module\nProcess/ProcessPageClone.module\nProcess/ProcessPageEdit/ProcessPageEdit.module\nProcess/ProcessPageEditImageSelect/ProcessPageEditImageSelect.module\nProcess/ProcessPageEditLink/ProcessPageEditLink.module\nProcess/ProcessPageList/ProcessPageList.module\nProcess/ProcessPageLister/ProcessPageLister.module\nProcess/ProcessPageSearch/ProcessPageSearch.module\nProcess/ProcessPagesExportImport/ProcessPagesExportImport.module\nProcess/ProcessPageSort.module\nProcess/ProcessPageTrash.module\nProcess/ProcessPageType/ProcessPageType.module\nProcess/ProcessPageView.module\nProcess/ProcessPermission/ProcessPermission.module\nProcess/ProcessProfile/ProcessProfile.module\nProcess/ProcessRecentPages/ProcessRecentPages.module\nProcess/ProcessRole/ProcessRole.module\nProcess/ProcessTemplate/ProcessTemplate.module\nProcess/ProcessUser/ProcessUser.module\nSession/SessionHandlerDB/ProcessSessionDB.module\nSession/SessionHandlerDB/SessionHandlerDB.module\nSession/SessionLoginThrottle/SessionLoginThrottle.module\nSystem/SystemNotifications/FieldtypeNotifications.module\nSystem/SystemNotifications/SystemNotifications.module\nSystem/SystemUpdater/SystemUpdater.module\nTextformatter/TextformatterEntities.module\nTextformatter/TextformatterMarkdownExtra/TextformatterMarkdownExtra.module\nTextformatter/TextformatterNewlineBR.module\nTextformatter/TextformatterNewlineUL.module\nTextformatter/TextformatterPstripper.module\nTextformatter/TextformatterSmartypants/TextformatterSmartypants.module\nTextformatter/TextformatterStripTags.module', '2023-08-17 21:02:24'),
(160, '.Modules.site/modules/', 8192, 'FormBuilder/FormBuilder.module\nFormBuilder/InputfieldFormBuilderFile.module\nFormBuilder/InputfieldFormBuilderForm.module\nFormBuilder/InputfieldFormBuilderPageBreak.module\nFormBuilder/ProcessFormBuilder.module\nFrontendForms/FrontendForms.module\nLoginRegister/LoginRegister.module', '2023-08-17 21:02:25'),
(161, '.Modules.info', 8192, '{\"148\":{\"name\":\"AdminThemeDefault\",\"title\":\"Default\",\"version\":14,\"autoload\":\"template=admin\",\"created\":1692306124,\"configurable\":19},\"166\":{\"name\":\"AdminThemeUikit\",\"title\":\"Uikit\",\"version\":33,\"autoload\":\"template=admin\",\"created\":1692306146,\"configurable\":4},\"97\":{\"name\":\"FieldtypeCheckbox\",\"title\":\"Checkbox\",\"version\":101,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"28\":{\"name\":\"FieldtypeDatetime\",\"title\":\"Datetime\",\"version\":105,\"created\":1692306124},\"29\":{\"name\":\"FieldtypeEmail\",\"title\":\"E-Mail\",\"version\":101,\"created\":1692306124},\"106\":{\"name\":\"FieldtypeFieldsetClose\",\"title\":\"Fieldset (Close)\",\"version\":100,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"105\":{\"name\":\"FieldtypeFieldsetOpen\",\"title\":\"Fieldset (Open)\",\"version\":101,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"107\":{\"name\":\"FieldtypeFieldsetTabOpen\",\"title\":\"Fieldset in Tab (Open)\",\"version\":100,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"6\":{\"name\":\"FieldtypeFile\",\"title\":\"Files\",\"version\":107,\"created\":1692306124,\"configurable\":4,\"permanent\":true},\"89\":{\"name\":\"FieldtypeFloat\",\"title\":\"Float\",\"version\":107,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"57\":{\"name\":\"FieldtypeImage\",\"title\":\"Images\",\"version\":102,\"created\":1692306124,\"configurable\":4,\"permanent\":true},\"84\":{\"name\":\"FieldtypeInteger\",\"title\":\"Integer\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"27\":{\"name\":\"FieldtypeModule\",\"title\":\"Module Reference\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"173\":{\"name\":\"FieldtypeOptions\",\"title\":\"Select Options\",\"version\":2,\"singular\":true,\"created\":1692366848},\"4\":{\"name\":\"FieldtypePage\",\"title\":\"Page Reference\",\"version\":107,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"111\":{\"name\":\"FieldtypePageTitle\",\"title\":\"Page Title\",\"version\":100,\"singular\":true,\"created\":1692306124,\"permanent\":true},\"133\":{\"name\":\"FieldtypePassword\",\"title\":\"Password\",\"version\":101,\"singular\":true,\"created\":1692306124,\"permanent\":true},\"174\":{\"name\":\"FieldtypeSelector\",\"title\":\"Selector\",\"version\":13,\"singular\":1,\"created\":1692366863},\"3\":{\"name\":\"FieldtypeText\",\"title\":\"Text\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"1\":{\"name\":\"FieldtypeTextarea\",\"title\":\"Textarea\",\"version\":107,\"created\":1692306124,\"permanent\":true},\"175\":{\"name\":\"FieldtypeToggle\",\"title\":\"Toggle (Yes\\/No)\",\"version\":1,\"requiresVersions\":{\"InputfieldToggle\":[\">=\",0]},\"singular\":true,\"created\":1692735599},\"135\":{\"name\":\"FieldtypeURL\",\"title\":\"URL\",\"version\":101,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"25\":{\"name\":\"InputfieldAsmSelect\",\"title\":\"asmSelect\",\"version\":203,\"created\":1692306124,\"permanent\":true},\"131\":{\"name\":\"InputfieldButton\",\"title\":\"Button\",\"version\":100,\"created\":1692306124,\"permanent\":true},\"37\":{\"name\":\"InputfieldCheckbox\",\"title\":\"Checkbox\",\"version\":106,\"created\":1692306124,\"permanent\":true},\"38\":{\"name\":\"InputfieldCheckboxes\",\"title\":\"Checkboxes\",\"version\":108,\"created\":1692306124,\"permanent\":true},\"94\":{\"name\":\"InputfieldDatetime\",\"title\":\"Datetime\",\"version\":107,\"created\":1692306124,\"permanent\":true},\"80\":{\"name\":\"InputfieldEmail\",\"title\":\"Email\",\"version\":102,\"created\":1692306124},\"78\":{\"name\":\"InputfieldFieldset\",\"title\":\"Fieldset\",\"version\":101,\"created\":1692306124,\"permanent\":true},\"55\":{\"name\":\"InputfieldFile\",\"title\":\"Files\",\"version\":128,\"created\":1692306124,\"permanent\":true},\"90\":{\"name\":\"InputfieldFloat\",\"title\":\"Float\",\"version\":105,\"created\":1692306124,\"permanent\":true},\"30\":{\"name\":\"InputfieldForm\",\"title\":\"Form\",\"version\":107,\"created\":1692306124,\"permanent\":true},\"40\":{\"name\":\"InputfieldHidden\",\"title\":\"Hidden\",\"version\":101,\"created\":1692306124,\"permanent\":true},\"168\":{\"name\":\"InputfieldIcon\",\"title\":\"Icon\",\"version\":3,\"created\":1692306150},\"56\":{\"name\":\"InputfieldImage\",\"title\":\"Images\",\"version\":126,\"created\":1692306124,\"permanent\":true},\"85\":{\"name\":\"InputfieldInteger\",\"title\":\"Integer\",\"version\":105,\"created\":1692306124,\"permanent\":true},\"79\":{\"name\":\"InputfieldMarkup\",\"title\":\"Markup\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"41\":{\"name\":\"InputfieldName\",\"title\":\"Name\",\"version\":100,\"created\":1692306124,\"permanent\":true},\"60\":{\"name\":\"InputfieldPage\",\"title\":\"Page\",\"version\":108,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"170\":{\"name\":\"InputfieldPageAutocomplete\",\"title\":\"Page Auto Complete\",\"version\":113,\"created\":1692307988},\"15\":{\"name\":\"InputfieldPageListSelect\",\"title\":\"Page List Select\",\"version\":101,\"created\":1692306124,\"permanent\":true},\"137\":{\"name\":\"InputfieldPageListSelectMultiple\",\"title\":\"Page List Select Multiple\",\"version\":103,\"created\":1692306124,\"permanent\":true},\"86\":{\"name\":\"InputfieldPageName\",\"title\":\"Page Name\",\"version\":106,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"112\":{\"name\":\"InputfieldPageTitle\",\"title\":\"Page Title\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"122\":{\"name\":\"InputfieldPassword\",\"title\":\"Password\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"39\":{\"name\":\"InputfieldRadios\",\"title\":\"Radio Buttons\",\"version\":106,\"created\":1692306124,\"permanent\":true},\"36\":{\"name\":\"InputfieldSelect\",\"title\":\"Select\",\"version\":102,\"created\":1692306124,\"permanent\":true},\"43\":{\"name\":\"InputfieldSelectMultiple\",\"title\":\"Select Multiple\",\"version\":101,\"created\":1692306124,\"permanent\":true},\"149\":{\"name\":\"InputfieldSelector\",\"title\":\"Selector\",\"version\":28,\"autoload\":\"template=admin\",\"created\":1692306124,\"configurable\":3,\"addFlag\":32},\"32\":{\"name\":\"InputfieldSubmit\",\"title\":\"Submit\",\"version\":103,\"created\":1692306124,\"permanent\":true},\"34\":{\"name\":\"InputfieldText\",\"title\":\"Text\",\"version\":106,\"created\":1692306124,\"permanent\":true},\"35\":{\"name\":\"InputfieldTextarea\",\"title\":\"Textarea\",\"version\":103,\"created\":1692306124,\"permanent\":true},\"169\":{\"name\":\"InputfieldTextTags\",\"title\":\"Text Tags\",\"version\":5,\"icon\":\"tags\",\"created\":1692307413},\"155\":{\"name\":\"InputfieldTinyMCE\",\"title\":\"TinyMCE\",\"version\":615,\"icon\":\"keyboard-o\",\"requiresVersions\":{\"ProcessWire\":[\">=\",\"3.0.200\"],\"MarkupHTMLPurifier\":[\">=\",0]},\"created\":1692306124,\"configurable\":4},\"172\":{\"name\":\"InputfieldToggle\",\"title\":\"Toggle\",\"version\":1,\"created\":1692308746},\"108\":{\"name\":\"InputfieldURL\",\"title\":\"URL\",\"version\":103,\"created\":1692306124},\"116\":{\"name\":\"JqueryCore\",\"title\":\"jQuery Core\",\"version\":\"1.12.4\",\"singular\":true,\"created\":1692306124,\"permanent\":true},\"151\":{\"name\":\"JqueryMagnific\",\"title\":\"jQuery Magnific Popup\",\"version\":\"1.1.0\",\"singular\":1,\"created\":1692306124},\"103\":{\"name\":\"JqueryTableSorter\",\"title\":\"jQuery Table Sorter Plugin\",\"version\":\"2.31.3\",\"singular\":1,\"created\":1692306124},\"117\":{\"name\":\"JqueryUI\",\"title\":\"jQuery UI\",\"version\":\"1.10.4\",\"singular\":true,\"created\":1692306124,\"permanent\":true},\"45\":{\"name\":\"JqueryWireTabs\",\"title\":\"jQuery Wire Tabs Plugin\",\"version\":110,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"67\":{\"name\":\"MarkupAdminDataTable\",\"title\":\"Admin Data Table\",\"version\":107,\"created\":1692306124,\"permanent\":true},\"156\":{\"name\":\"MarkupHTMLPurifier\",\"title\":\"HTML Purifier\",\"version\":497,\"created\":1692306124},\"113\":{\"name\":\"MarkupPageArray\",\"title\":\"PageArray Markup\",\"version\":100,\"autoload\":true,\"singular\":true,\"created\":1692306124},\"98\":{\"name\":\"MarkupPagerNav\",\"title\":\"Pager (Pagination) Navigation\",\"version\":105,\"created\":1692306124},\"176\":{\"name\":\"PageFrontEdit\",\"title\":\"Front-End Page Editor\",\"version\":6,\"icon\":\"cube\",\"autoload\":true,\"created\":1692744294,\"configurable\":\"PageFrontEditConfig.php\"},\"114\":{\"name\":\"PagePermissions\",\"title\":\"Page Permissions\",\"version\":105,\"autoload\":true,\"singular\":true,\"created\":1692306124,\"permanent\":true},\"115\":{\"name\":\"PageRender\",\"title\":\"Page Render\",\"version\":105,\"autoload\":true,\"singular\":true,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"48\":{\"name\":\"ProcessField\",\"title\":\"Fields\",\"version\":114,\"icon\":\"cube\",\"permission\":\"field-admin\",\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true,\"addFlag\":32},\"178\":{\"name\":\"ProcessForgotPassword\",\"title\":\"Forgot Password\",\"version\":104,\"permission\":\"page-view\",\"singular\":1,\"created\":1693533168,\"configurable\":4},\"87\":{\"name\":\"ProcessHome\",\"title\":\"Admin Home\",\"version\":101,\"permission\":\"page-view\",\"created\":1692306124,\"permanent\":true},\"76\":{\"name\":\"ProcessList\",\"title\":\"List\",\"version\":101,\"permission\":\"page-view\",\"created\":1692306124,\"permanent\":true},\"167\":{\"name\":\"ProcessLogger\",\"title\":\"Logs\",\"version\":2,\"icon\":\"tree\",\"permission\":\"logs-view\",\"singular\":1,\"created\":1692306150,\"useNavJSON\":true},\"10\":{\"name\":\"ProcessLogin\",\"title\":\"Login\",\"version\":109,\"permission\":\"page-view\",\"created\":1692306124,\"configurable\":4,\"permanent\":true},\"50\":{\"name\":\"ProcessModule\",\"title\":\"Modules\",\"version\":120,\"permission\":\"module-admin\",\"created\":1692306124,\"permanent\":true,\"useNavJSON\":true,\"nav\":[{\"url\":\"?site#tab_site_modules\",\"label\":\"Site\",\"icon\":\"plug\",\"navJSON\":\"navJSON\\/?site=1\"},{\"url\":\"?core#tab_core_modules\",\"label\":\"Core\",\"icon\":\"plug\",\"navJSON\":\"navJSON\\/?core=1\"},{\"url\":\"?configurable#tab_configurable_modules\",\"label\":\"Configure\",\"icon\":\"gear\",\"navJSON\":\"navJSON\\/?configurable=1\"},{\"url\":\"?install#tab_install_modules\",\"label\":\"Install\",\"icon\":\"sign-in\",\"navJSON\":\"navJSON\\/?install=1\"},{\"url\":\"?new#tab_new_modules\",\"label\":\"New\",\"icon\":\"plus\"},{\"url\":\"?reset=1\",\"label\":\"Refresh\",\"icon\":\"refresh\"}]},\"17\":{\"name\":\"ProcessPageAdd\",\"title\":\"Page Add\",\"version\":109,\"icon\":\"plus-circle\",\"permission\":\"page-edit\",\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"7\":{\"name\":\"ProcessPageEdit\",\"title\":\"Page Edit\",\"version\":112,\"icon\":\"edit\",\"permission\":\"page-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"129\":{\"name\":\"ProcessPageEditImageSelect\",\"title\":\"Page Edit Image\",\"version\":121,\"permission\":\"page-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"121\":{\"name\":\"ProcessPageEditLink\",\"title\":\"Page Edit Link\",\"version\":112,\"icon\":\"link\",\"permission\":\"page-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":4,\"permanent\":true},\"12\":{\"name\":\"ProcessPageList\",\"title\":\"Page List\",\"version\":124,\"icon\":\"sitemap\",\"permission\":\"page-edit\",\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"150\":{\"name\":\"ProcessPageLister\",\"title\":\"Lister\",\"version\":26,\"icon\":\"search\",\"permission\":\"page-lister\",\"created\":1692306124,\"configurable\":true,\"permanent\":true,\"useNavJSON\":true,\"addFlag\":32},\"104\":{\"name\":\"ProcessPageSearch\",\"title\":\"Page Search\",\"version\":108,\"permission\":\"page-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"14\":{\"name\":\"ProcessPageSort\",\"title\":\"Page Sort and Move\",\"version\":100,\"permission\":\"page-edit\",\"created\":1692306124,\"permanent\":true},\"109\":{\"name\":\"ProcessPageTrash\",\"title\":\"Page Trash\",\"version\":103,\"singular\":1,\"created\":1692306124,\"permanent\":true},\"134\":{\"name\":\"ProcessPageType\",\"title\":\"Page Type\",\"version\":101,\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true,\"addFlag\":32},\"83\":{\"name\":\"ProcessPageView\",\"title\":\"Page View\",\"version\":106,\"permission\":\"page-view\",\"created\":1692306124,\"permanent\":true},\"136\":{\"name\":\"ProcessPermission\",\"title\":\"Permissions\",\"version\":101,\"icon\":\"gear\",\"permission\":\"permission-admin\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"138\":{\"name\":\"ProcessProfile\",\"title\":\"User Profile\",\"version\":105,\"permission\":\"profile-edit\",\"singular\":1,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"165\":{\"name\":\"ProcessRecentPages\",\"title\":\"Recent Pages\",\"version\":2,\"icon\":\"clock-o\",\"permission\":\"page-edit-recent\",\"singular\":1,\"created\":1692306145,\"useNavJSON\":true,\"nav\":[{\"url\":\"?edited=1\",\"label\":\"Edited\",\"icon\":\"users\",\"navJSON\":\"navJSON\\/?edited=1\"},{\"url\":\"?added=1\",\"label\":\"Created\",\"icon\":\"users\",\"navJSON\":\"navJSON\\/?added=1\"},{\"url\":\"?edited=1&me=1\",\"label\":\"Edited by me\",\"icon\":\"user\",\"navJSON\":\"navJSON\\/?edited=1&me=1\"},{\"url\":\"?added=1&me=1\",\"label\":\"Created by me\",\"icon\":\"user\",\"navJSON\":\"navJSON\\/?added=1&me=1\"},{\"url\":\"another\\/\",\"label\":\"Add another\",\"icon\":\"plus-circle\",\"navJSON\":\"anotherNavJSON\\/\"}]},\"68\":{\"name\":\"ProcessRole\",\"title\":\"Roles\",\"version\":104,\"icon\":\"gears\",\"permission\":\"role-admin\",\"created\":1692306124,\"configurable\":3,\"permanent\":true,\"useNavJSON\":true},\"47\":{\"name\":\"ProcessTemplate\",\"title\":\"Templates\",\"version\":114,\"icon\":\"cubes\",\"permission\":\"template-admin\",\"created\":1692306124,\"configurable\":4,\"permanent\":true,\"useNavJSON\":true},\"66\":{\"name\":\"ProcessUser\",\"title\":\"Users\",\"version\":107,\"icon\":\"group\",\"permission\":\"user-admin\",\"created\":1692306124,\"configurable\":\"ProcessUserConfig.php\",\"permanent\":true,\"useNavJSON\":true},\"125\":{\"name\":\"SessionLoginThrottle\",\"title\":\"Session Login Throttle\",\"version\":103,\"autoload\":\"function\",\"singular\":true,\"created\":1692306124,\"configurable\":3},\"139\":{\"name\":\"SystemUpdater\",\"title\":\"System Updater\",\"version\":20,\"singular\":true,\"created\":1692306124,\"configurable\":3,\"permanent\":true},\"61\":{\"name\":\"TextformatterEntities\",\"title\":\"HTML Entity Encoder (htmlspecialchars)\",\"version\":100,\"created\":1692306124},\"171\":{\"name\":\"TextformatterMarkdownExtra\",\"title\":\"Markdown\\/Parsedown Extra\",\"version\":180,\"singular\":1,\"created\":1692308006,\"configurable\":4},\"177\":{\"name\":\"LoginRegister\",\"title\":\"Login\\/Register\",\"version\":2,\"icon\":\"user-plus\",\"created\":1693532993,\"configurable\":4},\"179\":{\"name\":\"FormBuilder\",\"title\":\"Form Builder\",\"version\":46,\"installs\":[\"ProcessFormBuilder\",\"InputfieldFormBuilderFile\"],\"autoload\":true,\"singular\":true,\"configurable\":true},\"180\":{\"name\":\"ProcessFormBuilder\",\"title\":\"Forms\",\"version\":46,\"icon\":\"building\",\"requiresVersions\":{\"FormBuilder\":[\">=\",0]},\"permission\":\"form-builder\",\"singular\":true,\"useNavJSON\":true,\"nav\":[{\"url\":\"?entries\",\"label\":\"Entries\",\"icon\":\"server\",\"navJSON\":\"navJSON\\/?get=entries\"},{\"url\":\"?edit\",\"label\":\"Edit\",\"icon\":\"pencil-square-o\",\"navJSON\":\"navJSON\\/?get=edit\"},{\"url\":\"addForm\\/\",\"label\":\"Add New\",\"icon\":\"plus-circle\",\"permission\":\"form-builder-add\"}]},\"181\":{\"name\":\"InputfieldFormBuilderFile\",\"title\":\"File (for FormBuilder)\",\"version\":2,\"requiresVersions\":{\"FormBuilder\":[\">=\",0]}}}', '2023-08-17 21:02:25'),
(162, '.ModulesVerbose.info', 8192, '{\"148\":{\"summary\":\"Minimal admin theme that supports all ProcessWire features.\",\"core\":true,\"versionStr\":\"0.1.4\"},\"166\":{\"summary\":\"Uikit v3 admin theme\",\"core\":true,\"versionStr\":\"0.3.3\"},\"97\":{\"summary\":\"This Fieldtype stores an ON\\/OFF toggle via a single checkbox. The ON value is 1 and OFF value is 0.\",\"core\":true,\"versionStr\":\"1.0.1\"},\"28\":{\"summary\":\"Field that stores a date and optionally time\",\"core\":true,\"versionStr\":\"1.0.5\"},\"29\":{\"summary\":\"Field that stores an e-mail address\",\"core\":true,\"versionStr\":\"1.0.1\"},\"106\":{\"summary\":\"Close a fieldset opened by FieldsetOpen. \",\"core\":true,\"versionStr\":\"1.0.0\"},\"105\":{\"summary\":\"Open a fieldset to group fields. Should be followed by a Fieldset (Close) after one or more fields.\",\"core\":true,\"versionStr\":\"1.0.1\"},\"107\":{\"summary\":\"Open a fieldset to group fields. Same as Fieldset (Open) except that it displays in a tab instead.\",\"core\":true,\"versionStr\":\"1.0.0\"},\"6\":{\"summary\":\"Field that stores one or more files\",\"core\":true,\"versionStr\":\"1.0.7\"},\"89\":{\"summary\":\"Field that stores a floating point number\",\"core\":true,\"versionStr\":\"1.0.7\"},\"57\":{\"summary\":\"Field that stores one or more GIF, JPG, or PNG images\",\"core\":true,\"versionStr\":\"1.0.2\"},\"84\":{\"summary\":\"Field that stores an integer\",\"core\":true,\"versionStr\":\"1.0.2\"},\"27\":{\"summary\":\"Field that stores a reference to another module\",\"core\":true,\"versionStr\":\"1.0.2\"},\"173\":{\"summary\":\"Field that stores single and multi select options.\",\"core\":true,\"versionStr\":\"0.0.2\"},\"4\":{\"summary\":\"Field that stores one or more references to ProcessWire pages\",\"core\":true,\"versionStr\":\"1.0.7\"},\"111\":{\"summary\":\"Field that stores a page title\",\"core\":true,\"versionStr\":\"1.0.0\"},\"133\":{\"summary\":\"Field that stores a hashed and salted password\",\"core\":true,\"versionStr\":\"1.0.1\"},\"174\":{\"summary\":\"Build a page finding selector visually.\",\"author\":\"Avoine + ProcessWire\",\"core\":true,\"versionStr\":\"0.1.3\"},\"3\":{\"summary\":\"Field that stores a single line of text\",\"core\":true,\"versionStr\":\"1.0.2\"},\"1\":{\"summary\":\"Field that stores multiple lines of text\",\"core\":true,\"versionStr\":\"1.0.7\"},\"175\":{\"summary\":\"Configurable yes\\/no, on\\/off toggle alternative to a checkbox, plus optional \\u201cother\\u201d option.\",\"core\":true,\"versionStr\":\"0.0.1\"},\"135\":{\"summary\":\"Field that stores a URL\",\"core\":true,\"versionStr\":\"1.0.1\"},\"25\":{\"summary\":\"Multiple selection, progressive enhancement to select multiple\",\"core\":true,\"versionStr\":\"2.0.3\"},\"131\":{\"summary\":\"Form button element that you can optionally pass an href attribute to.\",\"core\":true,\"versionStr\":\"1.0.0\"},\"37\":{\"summary\":\"Single checkbox toggle\",\"core\":true,\"versionStr\":\"1.0.6\"},\"38\":{\"summary\":\"Multiple checkbox toggles\",\"core\":true,\"versionStr\":\"1.0.8\"},\"94\":{\"summary\":\"Inputfield that accepts date and optionally time\",\"core\":true,\"versionStr\":\"1.0.7\"},\"80\":{\"summary\":\"E-Mail address in valid format\",\"core\":true,\"versionStr\":\"1.0.2\"},\"78\":{\"summary\":\"Groups one or more fields together in a container\",\"core\":true,\"versionStr\":\"1.0.1\"},\"55\":{\"summary\":\"One or more file uploads (sortable)\",\"core\":true,\"versionStr\":\"1.2.8\"},\"90\":{\"summary\":\"Floating point number with precision\",\"core\":true,\"versionStr\":\"1.0.5\"},\"30\":{\"summary\":\"Contains one or more fields in a form\",\"core\":true,\"versionStr\":\"1.0.7\"},\"40\":{\"summary\":\"Hidden value in a form\",\"core\":true,\"versionStr\":\"1.0.1\"},\"168\":{\"summary\":\"Select an icon\",\"core\":true,\"versionStr\":\"0.0.3\"},\"56\":{\"summary\":\"One or more image uploads (sortable)\",\"core\":true,\"versionStr\":\"1.2.6\"},\"85\":{\"summary\":\"Integer (positive or negative)\",\"core\":true,\"versionStr\":\"1.0.5\"},\"79\":{\"summary\":\"Contains any other markup and optionally child Inputfields\",\"core\":true,\"versionStr\":\"1.0.2\"},\"41\":{\"summary\":\"Text input validated as a ProcessWire name field\",\"core\":true,\"versionStr\":\"1.0.0\"},\"60\":{\"summary\":\"Select one or more pages\",\"core\":true,\"versionStr\":\"1.0.8\"},\"170\":{\"summary\":\"Multiple Page selection using auto completion and sorting capability. Intended for use as an input field for Page reference fields.\",\"core\":true,\"versionStr\":\"1.1.3\"},\"15\":{\"summary\":\"Selection of a single page from a ProcessWire page tree list\",\"core\":true,\"versionStr\":\"1.0.1\"},\"137\":{\"summary\":\"Selection of multiple pages from a ProcessWire page tree list\",\"core\":true,\"versionStr\":\"1.0.3\"},\"86\":{\"summary\":\"Text input validated as a ProcessWire Page name field\",\"core\":true,\"versionStr\":\"1.0.6\"},\"112\":{\"summary\":\"Handles input of Page Title and auto-generation of Page Name (when name is blank)\",\"core\":true,\"versionStr\":\"1.0.2\"},\"122\":{\"summary\":\"Password input with confirmation field that doesn&#039;t ever echo the input back.\",\"core\":true,\"versionStr\":\"1.0.2\"},\"39\":{\"summary\":\"Radio buttons for selection of a single item\",\"core\":true,\"versionStr\":\"1.0.6\"},\"36\":{\"summary\":\"Selection of a single value from a select pulldown\",\"core\":true,\"versionStr\":\"1.0.2\"},\"43\":{\"summary\":\"Select multiple items from a list\",\"core\":true,\"versionStr\":\"1.0.1\"},\"149\":{\"summary\":\"Build a page finding selector visually.\",\"author\":\"Avoine + ProcessWire\",\"core\":true,\"versionStr\":\"0.2.8\"},\"32\":{\"summary\":\"Form submit button\",\"core\":true,\"versionStr\":\"1.0.3\"},\"34\":{\"summary\":\"Single line of text\",\"core\":true,\"versionStr\":\"1.0.6\"},\"35\":{\"summary\":\"Multiple lines of text\",\"core\":true,\"versionStr\":\"1.0.3\"},\"169\":{\"summary\":\"Enables input of user entered tags or selection of predefined tags.\",\"core\":true,\"versionStr\":\"0.0.5\"},\"155\":{\"summary\":\"TinyMCE rich text editor version 6.4.1.\",\"core\":true,\"versionStr\":\"6.1.5\"},\"172\":{\"summary\":\"A toggle providing similar input capability to a checkbox but much more configurable.\",\"core\":true,\"versionStr\":\"0.0.1\"},\"108\":{\"summary\":\"URL in valid format\",\"core\":true,\"versionStr\":\"1.0.3\"},\"116\":{\"summary\":\"jQuery Core as required by ProcessWire Admin and plugins\",\"href\":\"https:\\/\\/jquery.com\",\"core\":true,\"versionStr\":\"1.12.4\"},\"151\":{\"summary\":\"Provides lightbox capability for image galleries. Replacement for FancyBox. Uses Magnific Popup by @dimsemenov.\",\"href\":\"https:\\/\\/github.com\\/dimsemenov\\/Magnific-Popup\\/\",\"core\":true,\"versionStr\":\"1.1.0\"},\"103\":{\"summary\":\"Provides a jQuery plugin for sorting tables.\",\"href\":\"https:\\/\\/mottie.github.io\\/tablesorter\\/\",\"core\":true,\"versionStr\":\"2.31.3\"},\"117\":{\"summary\":\"jQuery UI as required by ProcessWire and plugins\",\"href\":\"https:\\/\\/ui.jquery.com\",\"core\":true,\"versionStr\":\"1.10.4\"},\"45\":{\"summary\":\"Provides a jQuery plugin for generating tabs in ProcessWire.\",\"core\":true,\"versionStr\":\"1.1.0\"},\"67\":{\"summary\":\"Generates markup for data tables used by ProcessWire admin\",\"core\":true,\"versionStr\":\"1.0.7\"},\"156\":{\"summary\":\"Front-end to the HTML Purifier library.\",\"core\":true,\"versionStr\":\"4.9.7\"},\"113\":{\"summary\":\"Adds renderPager() method to all PaginatedArray types, for easy pagination output. Plus a render() method to PageArray instances.\",\"core\":true,\"versionStr\":\"1.0.0\"},\"98\":{\"summary\":\"Generates markup for pagination navigation\",\"core\":true,\"versionStr\":\"1.0.5\"},\"176\":{\"summary\":\"Enables front-end editing of page fields.\",\"author\":\"Ryan Cramer\",\"core\":true,\"versionStr\":\"0.0.6\",\"permissions\":{\"page-edit-front\":\"Use the front-end page editor\"},\"license\":\"MPL 2.0\"},\"114\":{\"summary\":\"Adds various permission methods to Page objects that are used by Process modules.\",\"core\":true,\"versionStr\":\"1.0.5\"},\"115\":{\"summary\":\"Adds a render method to Page and caches page output.\",\"core\":true,\"versionStr\":\"1.0.5\"},\"48\":{\"summary\":\"Edit individual fields that hold page data\",\"core\":true,\"versionStr\":\"1.1.4\",\"searchable\":\"fields\"},\"178\":{\"summary\":\"Provides password reset\\/email capability for the Login process.\",\"core\":true,\"versionStr\":\"1.0.4\"},\"87\":{\"summary\":\"Acts as a placeholder Process for the admin root. Ensures proper flow control after login.\",\"core\":true,\"versionStr\":\"1.0.1\"},\"76\":{\"summary\":\"Lists the Process assigned to each child page of the current\",\"core\":true,\"versionStr\":\"1.0.1\"},\"167\":{\"summary\":\"View and manage system logs.\",\"author\":\"Ryan Cramer\",\"core\":true,\"versionStr\":\"0.0.2\",\"permissions\":{\"logs-view\":\"Can view system logs\",\"logs-edit\":\"Can manage system logs\"},\"page\":{\"name\":\"logs\",\"parent\":\"setup\",\"title\":\"Logs\"}},\"10\":{\"summary\":\"Login to ProcessWire\",\"core\":true,\"versionStr\":\"1.0.9\"},\"50\":{\"summary\":\"List, edit or install\\/uninstall modules\",\"core\":true,\"versionStr\":\"1.2.0\"},\"17\":{\"summary\":\"Add a new page\",\"core\":true,\"versionStr\":\"1.0.9\"},\"7\":{\"summary\":\"Edit a Page\",\"core\":true,\"versionStr\":\"1.1.2\"},\"129\":{\"summary\":\"Provides image manipulation functions for image fields and rich text editors.\",\"core\":true,\"versionStr\":\"1.2.1\"},\"121\":{\"summary\":\"Provides a link capability as used by some Fieldtype modules (like rich text editors).\",\"core\":true,\"versionStr\":\"1.1.2\"},\"12\":{\"summary\":\"List pages in a hierarchical tree structure\",\"core\":true,\"versionStr\":\"1.2.4\"},\"150\":{\"summary\":\"Admin tool for finding and listing pages by any property.\",\"author\":\"Ryan Cramer\",\"core\":true,\"versionStr\":\"0.2.6\",\"permissions\":{\"page-lister\":\"Use Page Lister\"}},\"104\":{\"summary\":\"Provides a page search engine for admin use.\",\"core\":true,\"versionStr\":\"1.0.8\"},\"14\":{\"summary\":\"Handles page sorting and moving for PageList\",\"core\":true,\"versionStr\":\"1.0.0\"},\"109\":{\"summary\":\"Handles emptying of Page trash\",\"core\":true,\"versionStr\":\"1.0.3\"},\"134\":{\"summary\":\"List, Edit and Add pages of a specific type\",\"core\":true,\"versionStr\":\"1.0.1\"},\"83\":{\"summary\":\"All page views are routed through this Process\",\"core\":true,\"versionStr\":\"1.0.6\"},\"136\":{\"summary\":\"Manage system permissions\",\"core\":true,\"versionStr\":\"1.0.1\"},\"138\":{\"summary\":\"Enables user to change their password, email address and other settings that you define.\",\"core\":true,\"versionStr\":\"1.0.5\"},\"165\":{\"summary\":\"Shows a list of recently edited pages in your admin.\",\"author\":\"Ryan Cramer\",\"href\":\"http:\\/\\/modules.processwire.com\\/\",\"core\":true,\"versionStr\":\"0.0.2\",\"permissions\":{\"page-edit-recent\":\"Can see recently edited pages\"},\"page\":{\"name\":\"recent-pages\",\"parent\":\"page\",\"title\":\"Recent\"}},\"68\":{\"summary\":\"Manage user roles and what permissions are attached\",\"core\":true,\"versionStr\":\"1.0.4\"},\"47\":{\"summary\":\"List and edit the templates that control page output\",\"core\":true,\"versionStr\":\"1.1.4\",\"searchable\":\"templates\"},\"66\":{\"summary\":\"Manage system users\",\"core\":true,\"versionStr\":\"1.0.7\",\"searchable\":\"users\"},\"125\":{\"summary\":\"Throttles login attempts to help prevent dictionary attacks.\",\"core\":true,\"versionStr\":\"1.0.3\"},\"139\":{\"summary\":\"Manages system versions and upgrades.\",\"core\":true,\"versionStr\":\"0.2.0\"},\"61\":{\"summary\":\"Entity encode ampersands, quotes (single and double) and greater-than\\/less-than signs using htmlspecialchars(str, ENT_QUOTES). It is recommended that you use this on all text\\/textarea fields except those using a rich text editor or a markup language like Markdown.\",\"core\":true,\"versionStr\":\"1.0.0\"},\"171\":{\"summary\":\"Markdown\\/Parsedown extra lightweight markup language by Emanuil Rusev. Based on Markdown by John Gruber.\",\"core\":true,\"versionStr\":\"1.8.0\"},\"177\":{\"summary\":\"Login or register for an account in ProcessWire\",\"versionStr\":\"0.0.2\"},\"179\":{\"summary\":\"Create or edit forms and manage submitted entries.\",\"versionStr\":\"0.4.6\"},\"180\":{\"summary\":\"Create or edit forms and manage submitted entries.\",\"versionStr\":\"0.4.6\"},\"181\":{\"summary\":\"Form Builder file upload input (alpha test)\",\"versionStr\":\"0.0.2\"}}', '2023-08-17 21:02:25');
INSERT INTO `modules` (`id`, `class`, `flags`, `data`, `created`) VALUES
(163, '.ModulesUninstalled.info', 8192, '{\"AdminThemeReno\":{\"name\":\"AdminThemeReno\",\"title\":\"Reno\",\"version\":17,\"versionStr\":\"0.1.7\",\"author\":\"Tom Reno (Renobird)\",\"summary\":\"Admin theme for ProcessWire 2.5+ by Tom Reno (Renobird)\",\"requiresVersions\":{\"AdminThemeDefault\":[\">=\",0]},\"autoload\":\"template=admin\",\"created\":1692316722,\"installed\":false,\"configurable\":3,\"core\":true},\"AdminThemeUikit\":{\"name\":\"AdminThemeUikit\",\"title\":\"Uikit\",\"version\":33,\"versionStr\":\"0.3.3\",\"summary\":\"Uikit v3 admin theme\",\"autoload\":\"template=admin\",\"created\":1692305922,\"installed\":false,\"configurable\":4,\"core\":true},\"FieldtypeCache\":{\"name\":\"FieldtypeCache\",\"title\":\"Cache\",\"version\":102,\"versionStr\":\"1.0.2\",\"summary\":\"Caches the values of other fields for fewer runtime queries. Can also be used to combine multiple text fields and have them all be searchable under the cached field name.\",\"created\":1692316740,\"installed\":false,\"core\":true},\"CommentFilterAkismet\":{\"name\":\"CommentFilterAkismet\",\"title\":\"Comment Filter: Akismet\",\"version\":200,\"versionStr\":\"2.0.0\",\"summary\":\"Uses the Akismet service to identify comment spam. Module plugin for the Comments Fieldtype.\",\"requiresVersions\":{\"FieldtypeComments\":[\">=\",0]},\"created\":1692316742,\"installed\":false,\"configurable\":3,\"core\":true},\"FieldtypeComments\":{\"name\":\"FieldtypeComments\",\"title\":\"Comments\",\"version\":110,\"versionStr\":\"1.1.0\",\"summary\":\"Field that stores user posted comments for a single Page\",\"installs\":[\"InputfieldCommentsAdmin\"],\"created\":1692316742,\"installed\":false,\"core\":true},\"InputfieldCommentsAdmin\":{\"name\":\"InputfieldCommentsAdmin\",\"title\":\"Comments Admin\",\"version\":104,\"versionStr\":\"1.0.4\",\"summary\":\"Provides an administrative interface for working with comments\",\"requiresVersions\":{\"FieldtypeComments\":[\">=\",0]},\"created\":1692316742,\"installed\":false,\"core\":true},\"FieldtypeDecimal\":{\"name\":\"FieldtypeDecimal\",\"title\":\"Decimal\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Field that stores a decimal number\",\"created\":1692316740,\"installed\":false,\"core\":true},\"FieldtypeOptions\":{\"name\":\"FieldtypeOptions\",\"title\":\"Select Options\",\"version\":2,\"versionStr\":\"0.0.2\",\"summary\":\"Field that stores single and multi select options.\",\"created\":1692305941,\"installed\":false,\"core\":true},\"FieldtypePageTable\":{\"name\":\"FieldtypePageTable\",\"title\":\"ProFields: Page Table\",\"version\":8,\"versionStr\":\"0.0.8\",\"summary\":\"A fieldtype containing a group of editable pages.\",\"installs\":[\"InputfieldPageTable\"],\"autoload\":true,\"created\":1692316740,\"installed\":false,\"core\":true},\"FieldtypeFieldsetPage\":{\"name\":\"FieldtypeFieldsetPage\",\"title\":\"Fieldset (Page)\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Fieldset with fields isolated to separate namespace (page), enabling re-use of fields.\",\"requiresVersions\":{\"FieldtypeRepeater\":[\">=\",0]},\"autoload\":true,\"created\":1692316742,\"installed\":false,\"configurable\":3,\"core\":true},\"FieldtypeRepeater\":{\"name\":\"FieldtypeRepeater\",\"title\":\"Repeater\",\"version\":112,\"versionStr\":\"1.1.2\",\"summary\":\"Maintains a collection of fields that are repeated for any number of times.\",\"installs\":[\"InputfieldRepeater\"],\"autoload\":true,\"created\":1692316742,\"installed\":false,\"configurable\":3,\"core\":true},\"InputfieldRepeater\":{\"name\":\"InputfieldRepeater\",\"title\":\"Repeater\",\"version\":111,\"versionStr\":\"1.1.1\",\"summary\":\"Repeats fields from another template. Provides the input for FieldtypeRepeater.\",\"requiresVersions\":{\"FieldtypeRepeater\":[\">=\",0]},\"created\":1692316742,\"installed\":false,\"core\":true},\"FieldtypeSelector\":{\"name\":\"FieldtypeSelector\",\"title\":\"Selector\",\"version\":13,\"versionStr\":\"0.1.3\",\"author\":\"Avoine + ProcessWire\",\"summary\":\"Build a page finding selector visually.\",\"created\":1692305939,\"installed\":false,\"core\":true},\"FieldtypeToggle\":{\"name\":\"FieldtypeToggle\",\"title\":\"Toggle (Yes\\/No)\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Configurable yes\\/no, on\\/off toggle alternative to a checkbox, plus optional \\u201cother\\u201d option.\",\"requiresVersions\":{\"InputfieldToggle\":[\">=\",0]},\"created\":1692305939,\"installed\":false,\"core\":true},\"FileCompilerTags\":{\"name\":\"FileCompilerTags\",\"title\":\"Tags File Compiler\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Enables {var} or {var.property} variables in markup sections of a file. Can be used with any API variable.\",\"created\":1692316720,\"installed\":false,\"configurable\":4,\"core\":true},\"ImageSizerEngineAnimatedGif\":{\"name\":\"ImageSizerEngineAnimatedGif\",\"title\":\"Animated GIF Image Sizer\",\"version\":1,\"versionStr\":\"0.0.1\",\"author\":\"Horst Nogajski\",\"summary\":\"Upgrades image manipulations for animated GIFs.\",\"created\":1692316744,\"installed\":false,\"configurable\":4,\"core\":true},\"ImageSizerEngineIMagick\":{\"name\":\"ImageSizerEngineIMagick\",\"title\":\"IMagick Image Sizer\",\"version\":3,\"versionStr\":\"0.0.3\",\"author\":\"Horst Nogajski\",\"summary\":\"Upgrades image manipulations to use PHP\'s ImageMagick library when possible.\",\"created\":1692316744,\"installed\":false,\"configurable\":4,\"core\":true},\"InputfieldCKEditor\":{\"name\":\"InputfieldCKEditor\",\"title\":\"CKEditor\",\"version\":171,\"versionStr\":\"1.7.1\",\"summary\":\"CKEditor textarea rich text editor.\",\"installs\":[\"MarkupHTMLPurifier\"],\"created\":1692316744,\"installed\":false,\"core\":true},\"InputfieldIcon\":{\"name\":\"InputfieldIcon\",\"title\":\"Icon\",\"version\":3,\"versionStr\":\"0.0.3\",\"summary\":\"Select an icon\",\"created\":1692305964,\"installed\":false,\"core\":true},\"InputfieldPageAutocomplete\":{\"name\":\"InputfieldPageAutocomplete\",\"title\":\"Page Auto Complete\",\"version\":113,\"versionStr\":\"1.1.3\",\"summary\":\"Multiple Page selection using auto completion and sorting capability. Intended for use as an input field for Page reference fields.\",\"created\":1692305965,\"installed\":false,\"core\":true},\"InputfieldPageTable\":{\"name\":\"InputfieldPageTable\",\"title\":\"ProFields: Page Table\",\"version\":14,\"versionStr\":\"0.1.4\",\"summary\":\"Inputfield to accompany FieldtypePageTable\",\"requiresVersions\":{\"FieldtypePageTable\":[\">=\",0]},\"created\":1692316768,\"installed\":false,\"core\":true},\"InputfieldTextTags\":{\"name\":\"InputfieldTextTags\",\"title\":\"Text Tags\",\"version\":5,\"versionStr\":\"0.0.5\",\"summary\":\"Enables input of user entered tags or selection of predefined tags.\",\"icon\":\"tags\",\"created\":1692305967,\"installed\":false,\"core\":true},\"InputfieldToggle\":{\"name\":\"InputfieldToggle\",\"title\":\"Toggle\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"A toggle providing similar input capability to a checkbox but much more configurable.\",\"created\":1692305975,\"installed\":false,\"core\":true},\"FieldtypePageTitleLanguage\":{\"name\":\"FieldtypePageTitleLanguage\",\"title\":\"Page Title (Multi-Language)\",\"version\":100,\"versionStr\":\"1.0.0\",\"author\":\"Ryan Cramer\",\"summary\":\"Field that stores a page title in multiple languages. Use this only if you want title inputs created for ALL languages on ALL pages. Otherwise create separate languaged-named title fields, i.e. title_fr, title_es, title_fi, etc. \",\"requiresVersions\":{\"LanguageSupportFields\":[\">=\",0],\"FieldtypeTextLanguage\":[\">=\",0]},\"created\":1692316784,\"installed\":false,\"core\":true},\"FieldtypeTextareaLanguage\":{\"name\":\"FieldtypeTextareaLanguage\",\"title\":\"Textarea (Multi-language)\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Field that stores a multiple lines of text in multiple languages\",\"requiresVersions\":{\"LanguageSupportFields\":[\">=\",0]},\"created\":1692316784,\"installed\":false,\"core\":true},\"FieldtypeTextLanguage\":{\"name\":\"FieldtypeTextLanguage\",\"title\":\"Text (Multi-language)\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Field that stores a single line of text in multiple languages\",\"requiresVersions\":{\"LanguageSupportFields\":[\">=\",0]},\"created\":1692316784,\"installed\":false,\"core\":true},\"LanguageSupport\":{\"name\":\"LanguageSupport\",\"title\":\"Languages Support\",\"version\":103,\"versionStr\":\"1.0.3\",\"author\":\"Ryan Cramer\",\"summary\":\"ProcessWire multi-language support.\",\"installs\":[\"ProcessLanguage\",\"ProcessLanguageTranslator\"],\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"configurable\":3,\"core\":true,\"addFlag\":32},\"LanguageSupportFields\":{\"name\":\"LanguageSupportFields\",\"title\":\"Languages Support - Fields\",\"version\":101,\"versionStr\":\"1.0.1\",\"author\":\"Ryan Cramer\",\"summary\":\"Required to use multi-language fields.\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0]},\"installs\":[\"FieldtypePageTitleLanguage\",\"FieldtypeTextareaLanguage\",\"FieldtypeTextLanguage\"],\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"core\":true},\"LanguageSupportPageNames\":{\"name\":\"LanguageSupportPageNames\",\"title\":\"Languages Support - Page Names\",\"version\":13,\"versionStr\":\"0.1.3\",\"author\":\"Ryan Cramer\",\"summary\":\"Required to use multi-language page names.\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0],\"LanguageSupportFields\":[\">=\",0]},\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"configurable\":4,\"core\":true},\"LanguageTabs\":{\"name\":\"LanguageTabs\",\"title\":\"Languages Support - Tabs\",\"version\":117,\"versionStr\":\"1.1.7\",\"author\":\"adamspruijt, ryan, flipzoom\",\"summary\":\"Organizes multi-language fields into tabs for a cleaner easier to use interface.\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0]},\"autoload\":\"template=admin\",\"singular\":true,\"created\":1692316784,\"installed\":false,\"configurable\":4,\"core\":true},\"ProcessLanguage\":{\"name\":\"ProcessLanguage\",\"title\":\"Languages\",\"version\":103,\"versionStr\":\"1.0.3\",\"author\":\"Ryan Cramer\",\"summary\":\"Manage system languages\",\"icon\":\"language\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0]},\"permission\":\"lang-edit\",\"permissions\":{\"lang-edit\":\"Administer languages and static translation files\"},\"created\":1692316784,\"installed\":false,\"configurable\":3,\"core\":true,\"useNavJSON\":true},\"ProcessLanguageTranslator\":{\"name\":\"ProcessLanguageTranslator\",\"title\":\"Language Translator\",\"version\":103,\"versionStr\":\"1.0.3\",\"author\":\"Ryan Cramer\",\"summary\":\"Provides language translation capabilities for ProcessWire core and modules.\",\"requiresVersions\":{\"LanguageSupport\":[\">=\",0]},\"permission\":\"lang-edit\",\"created\":1692316784,\"installed\":false,\"configurable\":4,\"core\":true},\"LazyCron\":{\"name\":\"LazyCron\",\"title\":\"Lazy Cron\",\"version\":103,\"versionStr\":\"1.0.3\",\"summary\":\"Provides hooks that are automatically executed at various intervals. It is called \'lazy\' because it\'s triggered by a pageview, so the interval is guaranteed to be at least the time requested, rather than exactly the time requested. This is fine for most cases, but you can make it not lazy by connecting this to a real CRON job. See the module file for details. \",\"href\":\"https:\\/\\/processwire.com\\/api\\/modules\\/lazy-cron\\/\",\"autoload\":true,\"singular\":true,\"created\":1692316720,\"installed\":false,\"core\":true},\"MarkupCache\":{\"name\":\"MarkupCache\",\"title\":\"Markup Cache\",\"version\":101,\"versionStr\":\"1.0.1\",\"summary\":\"A simple way to cache segments of markup in your templates. \",\"href\":\"https:\\/\\/processwire.com\\/api\\/modules\\/markupcache\\/\",\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"configurable\":3,\"core\":true},\"MarkupPageFields\":{\"name\":\"MarkupPageFields\",\"title\":\"Markup Page Fields\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Adds $page->renderFields() and $page->images->render() methods that return basic markup for output during development and debugging.\",\"autoload\":true,\"singular\":true,\"created\":1692316784,\"installed\":false,\"core\":true,\"permanent\":true},\"MarkupRSS\":{\"name\":\"MarkupRSS\",\"title\":\"Markup RSS Feed\",\"version\":105,\"versionStr\":\"1.0.5\",\"summary\":\"Renders an RSS feed. Given a PageArray, renders an RSS feed of them.\",\"icon\":\"rss-square\",\"created\":1692316784,\"installed\":false,\"configurable\":3,\"core\":true},\"PageFrontEdit\":{\"name\":\"PageFrontEdit\",\"title\":\"Front-End Page Editor\",\"version\":6,\"versionStr\":\"0.0.6\",\"author\":\"Ryan Cramer\",\"summary\":\"Enables front-end editing of page fields.\",\"icon\":\"cube\",\"permissions\":{\"page-edit-front\":\"Use the front-end page editor\"},\"autoload\":true,\"created\":1692305989,\"installed\":false,\"configurable\":\"PageFrontEditConfig.php\",\"core\":true,\"license\":\"MPL 2.0\"},\"PagePathHistory\":{\"name\":\"PagePathHistory\",\"title\":\"Page Path History\",\"version\":8,\"versionStr\":\"0.0.8\",\"summary\":\"Keeps track of past URLs where pages have lived and automatically redirects (301 permanent) to the new location whenever the past URL is accessed.\",\"autoload\":true,\"singular\":true,\"created\":1692316720,\"installed\":false,\"configurable\":4,\"core\":true},\"PagePaths\":{\"name\":\"PagePaths\",\"title\":\"Page Paths\",\"version\":4,\"versionStr\":\"0.0.4\",\"summary\":\"Enables page paths\\/urls to be queryable by selectors. Also offers potential for improved load performance. Builds an index at install (may take time on a large site).\",\"autoload\":true,\"singular\":true,\"created\":1692316720,\"installed\":false,\"configurable\":4,\"core\":true},\"ProcessCommentsManager\":{\"name\":\"ProcessCommentsManager\",\"title\":\"Comments\",\"version\":12,\"versionStr\":\"0.1.2\",\"author\":\"Ryan Cramer\",\"summary\":\"Manage comments in your site outside of the page editor.\",\"icon\":\"comments\",\"requiresVersions\":{\"FieldtypeComments\":[\">=\",0]},\"permission\":\"comments-manager\",\"permissions\":{\"comments-manager\":\"Use the comments manager\"},\"created\":1692316790,\"installed\":false,\"searchable\":\"comments\",\"core\":true,\"page\":{\"name\":\"comments\",\"parent\":\"setup\",\"title\":\"Comments\"},\"nav\":[{\"url\":\"?go=approved\",\"label\":\"Approved\"},{\"url\":\"?go=pending\",\"label\":\"Pending\"},{\"url\":\"?go=spam\",\"label\":\"Spam\"},{\"url\":\"?go=all\",\"label\":\"All\"}]},\"ProcessForgotPassword\":{\"name\":\"ProcessForgotPassword\",\"title\":\"Forgot Password\",\"version\":104,\"versionStr\":\"1.0.4\",\"summary\":\"Provides password reset\\/email capability for the Login process.\",\"permission\":\"page-view\",\"created\":1692305989,\"installed\":false,\"configurable\":4,\"core\":true},\"ProcessLogger\":{\"name\":\"ProcessLogger\",\"title\":\"Logs\",\"version\":2,\"versionStr\":\"0.0.2\",\"author\":\"Ryan Cramer\",\"summary\":\"View and manage system logs.\",\"icon\":\"tree\",\"permission\":\"logs-view\",\"permissions\":{\"logs-view\":\"Can view system logs\",\"logs-edit\":\"Can manage system logs\"},\"created\":1692305990,\"installed\":false,\"core\":true,\"page\":{\"name\":\"logs\",\"parent\":\"setup\",\"title\":\"Logs\"},\"useNavJSON\":true},\"ProcessPageClone\":{\"name\":\"ProcessPageClone\",\"title\":\"Page Clone\",\"version\":104,\"versionStr\":\"1.0.4\",\"summary\":\"Provides ability to clone\\/copy\\/duplicate pages in the admin. Adds a &quot;copy&quot; option to all applicable pages in the PageList.\",\"permission\":\"page-clone\",\"permissions\":{\"page-clone\":\"Clone a page\",\"page-clone-tree\":\"Clone a tree of pages\"},\"autoload\":\"template=admin\",\"created\":1692316790,\"installed\":false,\"core\":true,\"page\":{\"name\":\"clone\",\"title\":\"Clone\",\"parent\":\"page\",\"status\":1024}},\"ProcessPagesExportImport\":{\"name\":\"ProcessPagesExportImport\",\"title\":\"Pages Export\\/Import\",\"version\":1,\"versionStr\":\"0.0.1\",\"author\":\"Ryan Cramer\",\"summary\":\"Enables exporting and importing of pages. Development version, not yet recommended for production use.\",\"icon\":\"paper-plane-o\",\"permission\":\"page-edit-export\",\"created\":1692316794,\"installed\":false,\"core\":true,\"page\":{\"name\":\"export-import\",\"parent\":\"page\",\"title\":\"Export\\/Import\"}},\"ProcessRecentPages\":{\"name\":\"ProcessRecentPages\",\"title\":\"Recent Pages\",\"version\":2,\"versionStr\":\"0.0.2\",\"author\":\"Ryan Cramer\",\"summary\":\"Shows a list of recently edited pages in your admin.\",\"href\":\"http:\\/\\/modules.processwire.com\\/\",\"icon\":\"clock-o\",\"permission\":\"page-edit-recent\",\"permissions\":{\"page-edit-recent\":\"Can see recently edited pages\"},\"created\":1692305992,\"installed\":false,\"core\":true,\"page\":{\"name\":\"recent-pages\",\"parent\":\"page\",\"title\":\"Recent\"},\"useNavJSON\":true,\"nav\":[{\"url\":\"?edited=1\",\"label\":\"Edited\",\"icon\":\"users\",\"navJSON\":\"navJSON\\/?edited=1\"},{\"url\":\"?added=1\",\"label\":\"Created\",\"icon\":\"users\",\"navJSON\":\"navJSON\\/?added=1\"},{\"url\":\"?edited=1&me=1\",\"label\":\"Edited by me\",\"icon\":\"user\",\"navJSON\":\"navJSON\\/?edited=1&me=1\"},{\"url\":\"?added=1&me=1\",\"label\":\"Created by me\",\"icon\":\"user\",\"navJSON\":\"navJSON\\/?added=1&me=1\"},{\"url\":\"another\\/\",\"label\":\"Add another\",\"icon\":\"plus-circle\",\"navJSON\":\"anotherNavJSON\\/\"}]},\"ProcessSessionDB\":{\"name\":\"ProcessSessionDB\",\"title\":\"Sessions\",\"version\":5,\"versionStr\":\"0.0.5\",\"summary\":\"Enables you to browse active database sessions.\",\"icon\":\"dashboard\",\"requiresVersions\":{\"SessionHandlerDB\":[\">=\",0]},\"created\":1692316794,\"installed\":false,\"core\":true,\"page\":{\"name\":\"sessions-db\",\"parent\":\"access\",\"title\":\"Sessions\"}},\"SessionHandlerDB\":{\"name\":\"SessionHandlerDB\",\"title\":\"Session Handler Database\",\"version\":6,\"versionStr\":\"0.0.6\",\"summary\":\"Installing this module makes ProcessWire store sessions in the database rather than the file system. Note that this module will log you out after install or uninstall.\",\"installs\":[\"ProcessSessionDB\"],\"created\":1692316794,\"installed\":false,\"configurable\":3,\"core\":true},\"FieldtypeNotifications\":{\"name\":\"FieldtypeNotifications\",\"title\":\"Notifications\",\"version\":4,\"versionStr\":\"0.0.4\",\"summary\":\"Field that stores user notifications.\",\"requiresVersions\":{\"SystemNotifications\":[\">=\",0]},\"created\":1692316794,\"installed\":false,\"core\":true},\"SystemNotifications\":{\"name\":\"SystemNotifications\",\"title\":\"System Notifications\",\"version\":12,\"versionStr\":\"0.1.2\",\"summary\":\"Adds support for notifications in ProcessWire (currently in development)\",\"icon\":\"bell\",\"installs\":[\"FieldtypeNotifications\"],\"autoload\":true,\"created\":1692316796,\"installed\":false,\"configurable\":\"SystemNotificationsConfig.php\",\"core\":true},\"TextformatterMarkdownExtra\":{\"name\":\"TextformatterMarkdownExtra\",\"title\":\"Markdown\\/Parsedown Extra\",\"version\":180,\"versionStr\":\"1.8.0\",\"summary\":\"Markdown\\/Parsedown extra lightweight markup language by Emanuil Rusev. Based on Markdown by John Gruber.\",\"created\":1692305995,\"installed\":false,\"configurable\":4,\"core\":true},\"TextformatterNewlineBR\":{\"name\":\"TextformatterNewlineBR\",\"title\":\"Newlines to XHTML Line Breaks\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Converts newlines to XHTML line break <br \\/> tags. \",\"created\":1692316796,\"installed\":false,\"core\":true},\"TextformatterNewlineUL\":{\"name\":\"TextformatterNewlineUL\",\"title\":\"Newlines to Unordered List\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Converts newlines to <li> list items and surrounds in an <ul> unordered list. \",\"created\":1692316796,\"installed\":false,\"core\":true},\"TextformatterPstripper\":{\"name\":\"TextformatterPstripper\",\"title\":\"Paragraph Stripper\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Strips paragraph <p> tags that may have been applied by other text formatters before it. \",\"created\":1692316796,\"installed\":false,\"core\":true},\"TextformatterSmartypants\":{\"name\":\"TextformatterSmartypants\",\"title\":\"SmartyPants Typographer\",\"version\":171,\"versionStr\":\"1.7.1\",\"summary\":\"Smart typography for web sites, by Michel Fortin based on SmartyPants by John Gruber. If combined with Markdown, it should be applied AFTER Markdown.\",\"created\":1692316796,\"installed\":false,\"configurable\":4,\"core\":true,\"url\":\"https:\\/\\/github.com\\/michelf\\/php-smartypants\"},\"TextformatterStripTags\":{\"name\":\"TextformatterStripTags\",\"title\":\"Strip Markup Tags\",\"version\":100,\"versionStr\":\"1.0.0\",\"summary\":\"Strips HTML\\/XHTML Markup Tags\",\"created\":1692316796,\"installed\":false,\"configurable\":3,\"core\":true},\"InputfieldFormBuilderForm\":{\"name\":\"InputfieldFormBuilderForm\",\"title\":\"Form (for FormBuilder)\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Enables you to include one FormBuilder form within another.\",\"requiresVersions\":{\"FormBuilder\":[\">=\",0]},\"created\":1694331233,\"installed\":false},\"InputfieldFormBuilderPageBreak\":{\"name\":\"InputfieldFormBuilderPageBreak\",\"title\":\"Page Break (for FormBuilder)\",\"version\":1,\"versionStr\":\"0.0.1\",\"summary\":\"Enables you to create separate paginations of a form in FormBuilder.\",\"requiresVersions\":{\"FormBuilder\":[\">=\",0]},\"created\":1694331233,\"installed\":false},\"FrontendForms\":{\"name\":\"FrontendForms\",\"title\":\"FrontendForms\",\"version\":\"2.1.43\",\"versionStr\":\"2.1.43\",\"author\":\"J\\u00fcrgen Kern\",\"summary\":\"Create forms and validate them using the Valitron library.\",\"href\":\"https:\\/\\/github.com\\/juergenweb\\/FrontendForms\",\"requiresVersions\":{\"PHP\":[\">=\",\"8.0.0\"],\"ProcessWire\":[\">=\",\"3.0.181\"]},\"autoload\":true,\"singular\":true,\"created\":1693550148,\"installed\":false,\"configurable\":4}}', '2023-08-17 21:02:25'),
(164, '.ModulesVersions.info', 8192, '[]', '2023-08-17 21:02:25'),
(165, 'ProcessRecentPages', 1, '', '2023-08-17 21:02:25'),
(166, 'AdminThemeUikit', 10, '{\"useAsLogin\":1,\"userAvatar\":\"icon.user-circle\",\"userLabel\":\"{Name}\",\"logoURL\":\"\",\"logoAction\":\"1\",\"layout\":\"\",\"ukGrid\":\"0\",\"maxWidth\":1200,\"groupNotices\":\"0\",\"cssURL\":\"\",\"inputSize\":\"m\",\"noBorderTypes\":[],\"offsetTypes\":[],\"toggleBehavior\":\"0\"}', '2023-08-17 21:02:26'),
(167, 'ProcessLogger', 1, '', '2023-08-17 21:02:30'),
(168, 'InputfieldIcon', 0, '', '2023-08-17 21:02:30'),
(169, 'InputfieldTextTags', 0, '', '2023-08-17 21:23:33'),
(170, 'InputfieldPageAutocomplete', 0, '', '2023-08-17 21:33:08'),
(171, 'TextformatterMarkdownExtra', 1, '', '2023-08-17 21:33:26'),
(172, 'InputfieldToggle', 0, '', '2023-08-17 21:45:46'),
(173, 'FieldtypeOptions', 1, '', '2023-08-18 13:54:08'),
(174, 'FieldtypeSelector', 1, '', '2023-08-18 13:54:23'),
(175, 'FieldtypeToggle', 1, '', '2023-08-22 20:19:59'),
(176, 'PageFrontEdit', 2, '{\"inlineEditFields\":[],\"inlineLimitPage\":1,\"buttonLocation\":\"auto\",\"buttonType\":\"auto\"}', '2023-08-22 22:44:54'),
(177, 'LoginRegister', 0, '{\"features\":[\"login\",\"profile\"],\"registerFields\":[\"email\",\"pass\"],\"profileFields\":[\"pass\",\"email\"],\"registerRoles\":[\"login-register:1045\"]}', '2023-09-01 01:49:53'),
(178, 'ProcessForgotPassword', 1, '', '2023-09-01 01:52:48'),
(179, 'FormBuilder', 3, '{\"lastMaint\":1694331277,\"schemaVersion\":2,\"licenseKey\":\"PWFB4.per8500.d6dfd8d58100528665a51d684acfc16f332fe59f\",\"embedFields\":[],\"embedTag\":\"form-builder\",\"fromEmail\":\"arif@nashirnet.net\",\"mailer\":\"\",\"inputfieldClasses\":[\"AsmSelect\",\"Checkbox\",\"Checkboxes\",\"Datetime\",\"Email\",\"Fieldset\",\"Float\",\"FormBuilderFile\",\"Hidden\",\"Integer\",\"Page\",\"Radios\",\"Select\",\"SelectMultiple\",\"Text\",\"Textarea\",\"URL\"],\"useRoles\":1,\"akismetKey\":\"\",\"csvDelimiter\":\",\",\"csvUseBOM\":\"\",\"filesPath\":\"{config.paths.cache}form-builder\\/\",\"embedCode\":\"<iframe src=\'{httpUrl}\' id=\'FormBuilderViewport_{name}\' class=\'FormBuilderViewport\' data-form=\'{name}\' title=\'{name}\' frameborder=\'0\' allowTransparency=\'true\' style=\'width: 100%; height: 900px;\'><\\/iframe>\",\"markup_list\":\"<div {attrs}>{out}\\n<\\/div>\",\"markup_item\":\"<div {attrs}>{out}\\n<\\/div>\",\"markup_item_label\":\"<label class=\'ui-widget-header\' for=\'{for}\'>{out}<\\/label>\",\"markup_item_content\":\"<div class=\'ui-widget-content\'>{out}<\\/div>\",\"markup_item_error\":\"<p><span class=\'ui-state-error\'>{out}<\\/span><\\/p>\",\"markup_item_description\":\"<p class=\'description\'>{out}<\\/p>\",\"markup_success\":\"<p class=\'ui-state-highlight\'>{out}<\\/p>\",\"markup_error\":\"<p class=\'ui-state-error\'>{out}<\\/p>\",\"classes_form\":\"\",\"classes_list\":\"Inputfields\",\"classes_list_clearfix\":\"ui-helper-clearfix\",\"classes_item\":\"Inputfield Inputfield_{name} ui-widget {class}\",\"classes_item_required\":\"InputfieldStateRequired\",\"classes_item_error\":\"InputfieldStateError ui-state-error\",\"classes_item_collapsed\":\"InputfieldStateCollapsed\",\"classes_item_column_width\":\"InputfieldColumnWidth\",\"classes_item_column_width_first\":\"InputfieldColumnWidthFirst\"}', '2023-09-10 07:34:36'),
(180, 'ProcessFormBuilder', 1, '', '2023-09-10 07:34:36'),
(181, 'InputfieldFormBuilderFile', 0, '', '2023-09-10 07:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `templates_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(128) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `status` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_users_id` int(10) UNSIGNED NOT NULL DEFAULT 2,
  `created` timestamp NOT NULL DEFAULT '2015-12-18 00:09:00',
  `created_users_id` int(10) UNSIGNED NOT NULL DEFAULT 2,
  `published` datetime DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `parent_id`, `templates_id`, `name`, `status`, `modified`, `modified_users_id`, `created`, `created_users_id`, `published`, `sort`) VALUES
(1, 0, 1, 'home', 9, '2023-09-06 18:05:19', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 0),
(2, 1, 2, 'processwire', 1035, '2023-08-17 21:02:26', 40, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 10),
(3, 2, 2, 'page', 21, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 0),
(6, 3, 2, 'add', 21, '2023-08-17 21:02:32', 40, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 1),
(7, 1, 2, 'trash', 1039, '2023-09-06 18:58:43', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 11),
(8, 3, 2, 'list', 21, '2023-08-17 21:02:36', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 0),
(9, 3, 2, 'sort', 1047, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 3),
(10, 3, 2, 'edit', 1045, '2023-08-17 21:02:36', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 4),
(11, 22, 2, 'template', 21, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 0),
(16, 22, 2, 'field', 21, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 2),
(21, 2, 2, 'module', 21, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 2),
(22, 2, 2, 'setup', 21, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 1),
(23, 2, 2, 'login', 1035, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 4),
(27, 1, 29, 'http404', 1035, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 3, '2023-08-18 03:02:04', 9),
(28, 2, 2, 'access', 13, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 3),
(29, 28, 2, 'users', 29, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 0),
(30, 28, 2, 'roles', 29, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 1),
(31, 28, 2, 'permissions', 29, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 2),
(32, 31, 5, 'page-edit', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 2),
(34, 31, 5, 'page-delete', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 3),
(35, 31, 5, 'page-move', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 4),
(36, 31, 5, 'page-view', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 0),
(37, 30, 4, 'guest', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 0),
(38, 30, 4, 'superuser', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 1),
(41, 29, 3, 'admin', 1, '2023-09-01 02:26:29', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 0),
(40, 29, 3, 'guest', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 1),
(50, 31, 5, 'page-sort', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 5),
(51, 31, 5, 'page-template', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 6),
(52, 31, 5, 'user-admin', 25, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 10),
(53, 31, 5, 'profile-edit', 1, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 13),
(54, 31, 5, 'page-lock', 1, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 8),
(300, 3, 2, 'search', 1045, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 6),
(301, 3, 2, 'trash', 1047, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 6),
(302, 3, 2, 'link', 1041, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 7),
(303, 3, 2, 'image', 1041, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 8),
(304, 2, 2, 'profile', 1025, '2023-08-17 21:02:04', 41, '2023-08-17 21:02:04', 41, '2023-08-18 03:02:04', 5),
(1006, 31, 5, 'page-lister', 1, '2023-08-17 21:02:04', 40, '2023-08-17 21:02:04', 40, '2023-08-18 03:02:04', 9),
(1007, 3, 2, 'lister', 1, '2023-08-17 21:02:04', 40, '2023-08-17 21:02:04', 40, '2023-08-18 03:02:04', 9),
(1010, 3, 2, 'recent-pages', 1, '2023-08-17 21:02:25', 40, '2023-08-17 21:02:25', 40, '2023-08-18 03:02:25', 10),
(1011, 31, 5, 'page-edit-recent', 1, '2023-08-17 21:02:25', 40, '2023-08-17 21:02:25', 40, '2023-08-18 03:02:25', 10),
(1012, 22, 2, 'logs', 1, '2023-08-17 21:02:30', 40, '2023-08-17 21:02:30', 40, '2023-08-18 03:02:30', 2),
(1013, 31, 5, 'logs-view', 1, '2023-08-17 21:02:30', 40, '2023-08-17 21:02:30', 40, '2023-08-18 03:02:30', 11),
(1014, 31, 5, 'logs-edit', 1, '2023-08-17 21:02:30', 40, '2023-08-17 21:02:30', 40, '2023-08-18 03:02:30', 12),
(1015, 1029, 51, 'rules-and-regulations', 1, '2023-08-27 00:30:00', 41, '2023-08-17 21:22:11', 41, '2023-08-18 03:22:11', 0),
(1016, 1015, 53, 'rules-regulations-for-the-employees', 1, '2023-08-22 21:06:04', 41, '2023-08-17 21:35:01', 41, '2023-08-18 03:38:56', 0),
(1017, 1015, 53, 'rules-regulations-for-the-customers', 1, '2023-08-22 21:06:38', 41, '2023-08-17 21:56:06', 41, '2023-08-18 03:56:18', 1),
(1018, 1029, 51, 'company-policies', 1, '2023-08-27 00:31:16', 41, '2023-08-17 22:29:51', 41, '2023-08-18 04:30:13', 1),
(1019, 1018, 53, 'employee-code-of-conduct-ethics-policy', 1, '2023-08-22 21:08:29', 41, '2023-08-17 22:34:35', 41, '2023-08-18 04:34:40', 0),
(1020, 1, 47, 'forms', 1, '2023-09-07 11:19:56', 41, '2023-08-17 22:42:55', 41, '2023-08-18 04:43:03', 4),
(1024, 1, 49, 'courses', 1025, '2023-09-07 11:01:58', 41, '2023-08-18 14:19:50', 41, '2023-08-18 20:20:14', 7),
(1025, 1024, 29, 'instructors', 1, '2023-08-18 14:34:48', 41, '2023-08-18 14:32:34', 41, '2023-08-18 20:34:45', 0),
(1026, 1025, 50, 'rahat-arif', 1, '2023-08-27 00:49:38', 41, '2023-08-18 14:35:48', 41, '2023-08-18 20:35:59', 0),
(1027, 1025, 50, 'muhammad-ali', 1, '2023-08-18 14:38:50', 41, '2023-08-18 14:36:20', 41, '2023-08-18 20:36:24', 1),
(1028, 1025, 50, 'jhon-smith', 1, '2023-08-18 14:39:09', 41, '2023-08-18 14:36:47', 41, '2023-08-18 20:36:51', 2),
(1029, 1024, 29, 'course-list', 1, '2023-08-22 21:04:03', 41, '2023-08-18 14:56:54', 41, '2023-08-18 20:56:57', 1),
(1030, 1029, 51, 'basic-employee-training', 1, '2023-08-27 00:42:10', 41, '2023-08-18 14:57:22', 41, '2023-08-18 20:59:00', 2),
(1031, 1029, 51, 'market-growth-course', 1, '2023-08-22 20:18:16', 41, '2023-08-18 15:29:10', 41, '2023-08-18 21:29:53', 3),
(1032, 1024, 52, 'all-courses', 1, '2023-08-22 21:47:21', 41, '2023-08-22 19:54:53', 41, '2023-08-23 01:55:02', 2),
(1033, 1029, 51, 'advanced-networking-course', 1, '2023-08-22 20:18:26', 41, '2023-08-22 20:09:21', 41, '2023-08-23 02:09:34', 4),
(1034, 1024, 29, 'course-categories', 1, '2023-08-22 20:11:37', 41, '2023-08-22 20:11:32', 41, '2023-08-23 02:11:37', 3),
(1035, 1034, 54, 'basic-course', 1, '2023-08-22 22:08:37', 41, '2023-08-22 20:11:55', 41, '2023-08-23 02:12:18', 0),
(1036, 1034, 54, 'advanced-course', 1, '2023-08-22 22:09:22', 41, '2023-08-22 20:12:11', 41, '2023-08-23 02:12:13', 1),
(1037, 1034, 54, 'networking-course', 1, '2023-08-22 22:08:14', 41, '2023-08-22 20:12:31', 41, '2023-08-23 02:12:33', 2),
(1038, 1034, 54, 'management-course', 1, '2023-08-22 22:04:23', 41, '2023-08-22 20:12:55', 41, '2023-08-23 02:12:57', 3),
(1039, 1030, 53, 'class-1', 1, '2023-08-22 20:55:46', 41, '2023-08-22 20:47:40', 41, '2023-08-23 02:48:09', 0),
(1040, 1033, 53, 'advanced-networking-course-class-one', 1, '2023-08-22 20:59:26', 41, '2023-08-22 20:58:32', 41, '2023-08-23 02:59:26', 0),
(1041, 1031, 53, 'market-growth-course-class-one', 1, '2023-08-22 20:59:20', 41, '2023-08-22 20:59:06', 41, '2023-08-23 02:59:20', 0),
(1042, 31, 5, 'page-edit-front', 1, '2023-08-22 22:44:55', 41, '2023-08-22 22:44:54', 41, '2023-08-23 04:44:54', 13),
(1043, 1020, 56, 'daily-duties-form', 1, '2023-09-10 09:33:00', 41, '2023-08-30 05:11:32', 41, '2023-08-30 11:11:36', 0),
(1044, 1, 57, 'profile', 1, '2023-08-30 05:48:19', 41, '2023-08-30 05:45:12', 41, '2023-08-30 11:45:24', 6),
(1045, 30, 4, 'login-register', 1, '2023-09-01 01:49:53', 41, '2023-09-01 01:49:53', 41, '2023-09-01 07:49:53', 2),
(1046, 1044, 58, 'login', 1, '2023-09-01 02:02:36', 41, '2023-09-01 02:02:19', 41, '2023-09-01 08:02:22', 0),
(1053, 29, 3, 'staff_test', 1, '2023-09-07 06:47:43', 41, '2023-09-01 04:29:41', 41, '2023-09-01 10:31:33', 2),
(1145, 1084, 61, 'admin', 1, '2023-09-06 18:58:55', 41, '2023-09-06 18:58:55', 41, '2023-09-07 00:58:55', 0),
(1146, 1145, 62, 'admin-06-09-2023-20-59-00', 1, '2023-09-06 18:59:00', 41, '2023-09-06 18:59:00', 41, '2023-09-07 00:59:00', 0),
(1147, 1145, 62, 'admin-06-09-2023-20-59-08', 1, '2023-09-06 18:59:08', 41, '2023-09-06 18:59:08', 41, '2023-09-07 00:59:08', 1),
(1122, 1, 63, 'emergency-numbers', 1, '2023-09-07 11:12:20', 41, '2023-09-03 09:17:27', 41, '2023-09-03 15:19:21', 8),
(1123, 1043, 59, 'admin', 1, '2023-09-03 09:27:33', 41, '2023-09-03 09:27:33', 41, '2023-09-03 15:27:33', 0),
(1126, 1, 29, 'form-page', 1, '2023-09-06 18:05:19', 41, '2023-09-06 18:05:03', 41, '2023-09-07 00:05:07', 5),
(1127, 1126, 64, 'daily-duties-list', 1, '2023-09-07 08:21:58', 41, '2023-09-06 18:05:41', 41, '2023-09-07 00:05:44', 0),
(1129, 1126, 65, 'generator-portal-list', 1, '2023-09-06 18:39:43', 41, '2023-09-06 18:39:30', 41, '2023-09-07 00:39:41', 1),
(1084, 1020, 61, 'generator-portal', 1, '2023-09-07 11:03:24', 41, '2023-09-02 14:09:15', 41, '2023-09-02 20:09:40', 4),
(1148, 1123, 60, 'admin-07-09-2023-08-16-03', 1, '2023-09-07 06:16:03', 41, '2023-09-07 06:16:03', 41, '2023-09-07 09:16:03', 0),
(1149, 1145, 62, 'admin-07-09-2023-08-19-51', 1, '2023-09-07 06:19:51', 41, '2023-09-07 06:19:51', 41, '2023-09-07 09:19:51', 2),
(1150, 1043, 59, 'staff_test', 1, '2023-09-07 06:48:23', 1053, '2023-09-07 06:48:23', 1053, '2023-09-07 09:48:23', 1),
(1151, 1150, 60, 'staff_test-07-09-2023-08-49-54', 1, '2023-09-07 06:49:54', 1053, '2023-09-07 06:49:54', 1053, '2023-09-07 09:49:54', 0),
(1152, 29, 3, 'staff_test_2', 1, '2023-09-07 10:42:17', 41, '2023-09-07 10:40:46', 41, '2023-09-07 13:42:17', 3),
(1153, 1084, 61, 'staff_test_2', 1, '2023-09-07 10:43:02', 1152, '2023-09-07 10:43:02', 1152, '2023-09-07 13:43:02', 1),
(1154, 1153, 62, 'staff_test_2-07-09-2023-13-43-21', 1, '2023-09-07 10:43:21', 1152, '2023-09-07 10:43:21', 1152, '2023-09-07 13:43:21', 0),
(1155, 1123, 60, 'admin-07-09-2023-13-49-29', 1, '2023-09-07 10:49:29', 41, '2023-09-07 10:49:29', 41, '2023-09-07 13:49:29', 1),
(1156, 1043, 59, 'staff_test_2', 1, '2023-09-07 10:50:11', 1152, '2023-09-07 10:50:11', 1152, '2023-09-07 13:50:11', 2),
(1157, 1153, 60, 'staff_test_2-07-09-2023-13-50-44', 1, '2023-09-07 10:50:44', 1152, '2023-09-07 10:50:44', 1152, '2023-09-07 13:50:44', 1),
(1158, 1145, 62, 'admin-07-09-2023-14-56-14', 1, '2023-09-07 11:56:14', 41, '2023-09-07 11:56:14', 41, '2023-09-07 14:56:14', 3),
(1159, 1123, 60, 'admin-07-09-2023-15-03-23', 1, '2023-09-07 12:03:23', 41, '2023-09-07 12:03:23', 41, '2023-09-07 15:03:23', 2),
(1160, 1, 66, 'form-builder', 1025, '2023-09-10 07:34:36', 41, '2023-09-10 07:34:36', 41, '2023-09-10 10:34:36', 8),
(1161, 31, 5, 'form-builder', 1, '2023-09-10 07:34:36', 41, '2023-09-10 07:34:36', 41, '2023-09-10 10:34:36', 14),
(1162, 31, 5, 'form-builder-add', 1, '2023-09-10 07:34:36', 41, '2023-09-10 07:34:36', 41, '2023-09-10 10:34:36', 15),
(1163, 22, 2, 'form-builder', 1, '2023-09-10 07:34:36', 41, '2023-09-10 07:34:36', 41, '2023-09-10 10:34:36', 3),
(1164, 1043, 59, 'sss', 2049, '2023-09-10 07:48:16', 41, '2023-09-10 07:48:16', 41, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pages_access`
--

CREATE TABLE `pages_access` (
  `pages_id` int(11) NOT NULL,
  `templates_id` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pages_access`
--

INSERT INTO `pages_access` (`pages_id`, `templates_id`, `ts`) VALUES
(37, 2, '2023-08-17 21:02:04'),
(38, 2, '2023-08-17 21:02:04'),
(32, 2, '2023-08-17 21:02:04'),
(34, 2, '2023-08-17 21:02:04'),
(35, 2, '2023-08-17 21:02:04'),
(36, 2, '2023-08-17 21:02:04'),
(50, 2, '2023-08-17 21:02:04'),
(51, 2, '2023-08-17 21:02:04'),
(52, 2, '2023-08-17 21:02:04'),
(53, 2, '2023-08-17 21:02:04'),
(54, 2, '2023-08-17 21:02:04'),
(1006, 2, '2023-08-17 21:02:04'),
(1011, 2, '2023-08-17 21:02:25'),
(1013, 2, '2023-08-17 21:02:30'),
(1014, 2, '2023-08-17 21:02:30'),
(1015, 1, '2023-08-17 21:22:11'),
(1019, 1, '2023-08-22 21:08:29'),
(1017, 1, '2023-08-22 21:06:38'),
(1018, 1, '2023-08-17 22:29:51'),
(1016, 1, '2023-08-22 21:06:04'),
(1020, 1, '2023-08-17 22:42:55'),
(1146, 1, '2023-09-06 18:59:00'),
(1024, 1, '2023-08-18 14:19:50'),
(1025, 1, '2023-08-18 14:32:34'),
(1026, 1, '2023-08-18 14:35:48'),
(1027, 1, '2023-08-18 14:36:20'),
(1028, 1, '2023-08-18 14:36:47'),
(1029, 1, '2023-08-18 14:56:54'),
(1030, 1, '2023-08-18 14:57:22'),
(1031, 1, '2023-08-18 15:29:10'),
(1032, 1, '2023-08-22 19:54:53'),
(1033, 1, '2023-08-22 20:09:21'),
(1034, 1, '2023-08-22 20:11:32'),
(1035, 1, '2023-08-22 20:11:55'),
(1036, 1, '2023-08-22 20:12:11'),
(1037, 1, '2023-08-22 20:12:31'),
(1038, 1, '2023-08-22 20:12:55'),
(1039, 1, '2023-08-22 20:47:40'),
(1040, 1, '2023-08-22 20:58:32'),
(1041, 1, '2023-08-22 20:59:06'),
(1042, 2, '2023-08-22 22:44:55'),
(1043, 1, '2023-08-30 05:11:32'),
(1044, 1, '2023-08-30 05:45:12'),
(1045, 2, '2023-09-01 01:49:53'),
(1046, 1, '2023-09-01 02:02:19'),
(1127, 1, '2023-09-06 18:05:41'),
(1123, 1, '2023-09-03 09:27:33'),
(1147, 1, '2023-09-06 18:59:08'),
(1126, 1, '2023-09-06 18:05:03'),
(1122, 1, '2023-09-03 09:17:27'),
(1129, 1, '2023-09-06 18:39:30'),
(1145, 1, '2023-09-06 18:58:55'),
(1084, 1, '2023-09-02 14:09:15'),
(1148, 1, '2023-09-07 06:16:03'),
(1149, 1, '2023-09-07 06:19:51'),
(1150, 1, '2023-09-07 06:48:23'),
(1151, 1, '2023-09-07 06:49:54'),
(1153, 1, '2023-09-07 10:43:02'),
(1154, 1, '2023-09-07 10:43:21'),
(1155, 1, '2023-09-07 10:49:29'),
(1156, 1, '2023-09-07 10:50:11'),
(1157, 1, '2023-09-07 10:50:44'),
(1158, 1, '2023-09-07 11:56:14'),
(1159, 1, '2023-09-07 12:03:23'),
(1160, 1, '2023-09-10 07:34:36'),
(1161, 2, '2023-09-10 07:34:36'),
(1162, 2, '2023-09-10 07:34:36'),
(1164, 1, '2023-09-10 07:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `pages_parents`
--

CREATE TABLE `pages_parents` (
  `pages_id` int(10) UNSIGNED NOT NULL,
  `parents_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pages_parents`
--

INSERT INTO `pages_parents` (`pages_id`, `parents_id`) VALUES
(2, 1),
(3, 1),
(3, 2),
(7, 1),
(22, 1),
(22, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(29, 28),
(30, 1),
(30, 2),
(30, 28),
(31, 1),
(31, 2),
(31, 28),
(1025, 1024),
(1029, 1024),
(1030, 1024),
(1030, 1029),
(1031, 1024),
(1031, 1029),
(1033, 1024),
(1033, 1029),
(1034, 1024),
(1043, 1020),
(1084, 1020),
(1123, 1020),
(1123, 1043),
(1145, 1020),
(1145, 1084),
(1150, 1020),
(1150, 1043),
(1153, 1020),
(1153, 1084);

-- --------------------------------------------------------

--
-- Table structure for table `pages_sortfields`
--

CREATE TABLE `pages_sortfields` (
  `pages_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sortfield` varchar(20) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `process_forgot_password`
--

CREATE TABLE `process_forgot_password` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `token` char(32) NOT NULL,
  `ts` int(10) UNSIGNED NOT NULL,
  `ip` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ascii COLLATE=ascii_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_login_throttle`
--

CREATE TABLE `session_login_throttle` (
  `name` varchar(128) NOT NULL,
  `attempts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `last_attempt` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `session_login_throttle`
--

INSERT INTO `session_login_throttle` (`name`, `attempts`, `last_attempt`) VALUES
('admin', 1, 1694330222);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `fieldgroups_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `flags` int(11) NOT NULL DEFAULT 0,
  `cache_time` mediumint(9) NOT NULL DEFAULT 0,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `fieldgroups_id`, `flags`, `cache_time`, `data`) VALUES
(2, 'admin', 2, 8, 0, '{\"useRoles\":1,\"parentTemplates\":[2],\"allowPageNum\":1,\"redirectLogin\":23,\"slashUrls\":1,\"noGlobal\":1,\"compile\":3,\"modified\":1693547420,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(3, 'user', 3, 8, 0, '{\"useRoles\":1,\"noChildren\":1,\"parentTemplates\":[2],\"slashUrls\":1,\"pageClass\":\"User\",\"noGlobal\":1,\"noMove\":1,\"noTrash\":1,\"noSettings\":1,\"noChangeTemplate\":1,\"compile\":0,\"nameContentTab\":1,\"modified\":1693534544,\"_lazy\":1}'),
(4, 'role', 4, 8, 0, '{\"noChildren\":1,\"parentTemplates\":[2],\"slashUrls\":1,\"pageClass\":\"Role\",\"noGlobal\":1,\"noMove\":1,\"noTrash\":1,\"noSettings\":1,\"noChangeTemplate\":1,\"nameContentTab\":1}'),
(5, 'permission', 5, 8, 0, '{\"noChildren\":1,\"parentTemplates\":[2],\"slashUrls\":1,\"guestSearchable\":1,\"pageClass\":\"Permission\",\"noGlobal\":1,\"noMove\":1,\"noTrash\":1,\"noSettings\":1,\"noChangeTemplate\":1,\"nameContentTab\":1}'),
(1, 'home', 1, 0, 0, '{\"useRoles\":1,\"noParents\":1,\"slashUrls\":1,\"compile\":3,\"modified\":1694084061,\"ns\":\"ProcessWire\",\"_lazy\":1,\"roles\":[37]}'),
(29, 'basic-page', 83, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1692378668,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(57, 'profile', 111, 0, 0, '{\"slashUrls\":1,\"compile\":3,\"modified\":1693552850,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(56, 'daily_duties_form', 110, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1694088063,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(54, 'course_category', 108, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693549096,\"ns\":\"ProcessWire\",\"_lazy\":\"*\"}'),
(47, 'forms', 101, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693548804,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(48, 'form_page', 102, 0, 0, '{\"slashUrls\":1,\"altFilename\":\"form_page\",\"compile\":0,\"modified\":1693547912,\"ns\":\"ProcessWire\",\"_lazy\":\"*\"}'),
(49, 'courses', 103, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693697064,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(50, 'instructor', 104, 0, 0, '{\"slashUrls\":1,\"altFilename\":\"instructor\",\"compile\":0,\"modified\":1693549120,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(51, 'course_page', 105, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693547930,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(52, 'all-courses', 106, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693549102,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(53, 'course_material', 107, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693547968,\"ns\":\"ProcessWire\",\"_lazy\":\"*\"}'),
(58, 'login', 112, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693548292,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(60, 'daily_duties_data', 114, 0, 0, '{\"slashUrls\":1,\"altFilename\":\"daily_duties_data\",\"compile\":0,\"modified\":1694074545,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(59, 'form_submit_user', 113, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693542423,\"_lazy\":1}'),
(61, 'generator_portal_form', 115, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1694338448,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(62, 'generator_portal_data', 116, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1693662345,\"_lazy\":1}'),
(63, 'emergency_numbers', 117, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1694086904,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(64, 'daily_duties_list', 118, 0, 0, '{\"slashUrls\":1,\"compile\":0,\"modified\":1694084780,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(65, 'generator_portal_list', 119, 0, 0, '{\"slashUrls\":1,\"compile\":3,\"modified\":1694069910,\"ns\":\"ProcessWire\",\"_lazy\":1}'),
(66, 'form-builder', 120, 8, 0, '{\"noParents\":1,\"urlSegments\":1,\"slashUrls\":1,\"noGlobal\":1,\"compile\":3,\"modified\":1694331725,\"ns\":\"ProcessWire\",\"_lazy\":1}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caches`
--
ALTER TABLE `caches`
  ADD PRIMARY KEY (`name`),
  ADD KEY `expires` (`expires`);

--
-- Indexes for table `fieldgroups`
--
ALTER TABLE `fieldgroups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `fieldgroups_fields`
--
ALTER TABLE `fieldgroups_fields`
  ADD PRIMARY KEY (`fieldgroups_id`,`fields_id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `fieldtype_options`
--
ALTER TABLE `fieldtype_options`
  ADD PRIMARY KEY (`fields_id`,`option_id`),
  ADD UNIQUE KEY `title` (`title`(250),`fields_id`),
  ADD KEY `value` (`value`,`fields_id`),
  ADD KEY `sort` (`sort`,`fields_id`);
ALTER TABLE `fieldtype_options` ADD FULLTEXT KEY `title_ft` (`title`);
ALTER TABLE `fieldtype_options` ADD FULLTEXT KEY `value_ft` (`value`);

--
-- Indexes for table `field_ac_input`
--
ALTER TABLE `field_ac_input`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_admin_theme`
--
ALTER TABLE `field_admin_theme`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_backup_per_device`
--
ALTER TABLE `field_backup_per_device`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_backup_per_gb`
--
ALTER TABLE `field_backup_per_gb`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_backup_vps`
--
ALTER TABLE `field_backup_vps`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_bandwidth_physical`
--
ALTER TABLE `field_bandwidth_physical`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_bandwidth_process_hypers`
--
ALTER TABLE `field_bandwidth_process_hypers`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_bandwidth_vps`
--
ALTER TABLE `field_bandwidth_vps`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_cancelation_requests`
--
ALTER TABLE `field_cancelation_requests`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_course_category`
--
ALTER TABLE `field_course_category`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`,`pages_id`,`sort`);

--
-- Indexes for table `field_date`
--
ALTER TABLE `field_date`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_email`
--
ALTER TABLE `field_email`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data_exact` (`data`);
ALTER TABLE `field_email` ADD FULLTEXT KEY `data` (`data`);

--
-- Indexes for table `field_employee_name`
--
ALTER TABLE `field_employee_name`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`,`pages_id`,`sort`);

--
-- Indexes for table `field_form_edit_fields`
--
ALTER TABLE `field_form_edit_fields`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data_exact` (`data`(250));
ALTER TABLE `field_form_edit_fields` ADD FULLTEXT KEY `data` (`data`);

--
-- Indexes for table `field_form_visibility`
--
ALTER TABLE `field_form_visibility`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_instructor`
--
ALTER TABLE `field_instructor`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`,`pages_id`,`sort`);

--
-- Indexes for table `field_is_featured`
--
ALTER TABLE `field_is_featured`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_page_body`
--
ALTER TABLE `field_page_body`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data_exact` (`data`(250));
ALTER TABLE `field_page_body` ADD FULLTEXT KEY `data` (`data`);

--
-- Indexes for table `field_page_images`
--
ALTER TABLE `field_page_images`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`),
  ADD KEY `modified` (`modified`),
  ADD KEY `created` (`created`),
  ADD KEY `filesize` (`filesize`),
  ADD KEY `width` (`width`),
  ADD KEY `height` (`height`),
  ADD KEY `ratio` (`ratio`);
ALTER TABLE `field_page_images` ADD FULLTEXT KEY `description` (`description`);
ALTER TABLE `field_page_images` ADD FULLTEXT KEY `filedata` (`filedata`);

--
-- Indexes for table `field_pass`
--
ALTER TABLE `field_pass`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_permissions`
--
ALTER TABLE `field_permissions`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`,`pages_id`,`sort`);

--
-- Indexes for table `field_process`
--
ALTER TABLE `field_process`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_profile_photo`
--
ALTER TABLE `field_profile_photo`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`),
  ADD KEY `modified` (`modified`),
  ADD KEY `created` (`created`),
  ADD KEY `filesize` (`filesize`),
  ADD KEY `width` (`width`),
  ADD KEY `height` (`height`),
  ADD KEY `ratio` (`ratio`);
ALTER TABLE `field_profile_photo` ADD FULLTEXT KEY `description` (`description`);
ALTER TABLE `field_profile_photo` ADD FULLTEXT KEY `filedata` (`filedata`);

--
-- Indexes for table `field_raid_health_hypers`
--
ALTER TABLE `field_raid_health_hypers`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_roles`
--
ALTER TABLE `field_roles`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`,`pages_id`,`sort`);

--
-- Indexes for table `field_room_alert`
--
ALTER TABLE `field_room_alert`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`);

--
-- Indexes for table `field_short_description`
--
ALTER TABLE `field_short_description`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data_exact` (`data`(250));
ALTER TABLE `field_short_description` ADD FULLTEXT KEY `data` (`data`);

--
-- Indexes for table `field_thumbnail`
--
ALTER TABLE `field_thumbnail`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`),
  ADD KEY `modified` (`modified`),
  ADD KEY `created` (`created`),
  ADD KEY `filesize` (`filesize`),
  ADD KEY `width` (`width`),
  ADD KEY `height` (`height`),
  ADD KEY `ratio` (`ratio`);
ALTER TABLE `field_thumbnail` ADD FULLTEXT KEY `description` (`description`);
ALTER TABLE `field_thumbnail` ADD FULLTEXT KEY `filedata` (`filedata`);

--
-- Indexes for table `field_title`
--
ALTER TABLE `field_title`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `data_exact` (`data`(255));
ALTER TABLE `field_title` ADD FULLTEXT KEY `data` (`data`);

--
-- Indexes for table `field_user_id`
--
ALTER TABLE `field_user_id`
  ADD PRIMARY KEY (`pages_id`,`sort`),
  ADD KEY `data` (`data`,`pages_id`,`sort`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `forms_entries`
--
ALTER TABLE `forms_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forms_id` (`forms_id`,`flags`),
  ADD KEY `created_forms_id` (`created`,`forms_id`,`flags`),
  ADD KEY `modified_forms_id` (`modified`,`forms_id`,`flags`),
  ADD KEY `id_str` (`id`,`str`);
ALTER TABLE `forms_entries` ADD FULLTEXT KEY `data` (`data`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class` (`class`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_parent_id` (`name`,`parent_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `templates_id` (`templates_id`),
  ADD KEY `modified` (`modified`),
  ADD KEY `created` (`created`),
  ADD KEY `status` (`status`),
  ADD KEY `published` (`published`);

--
-- Indexes for table `pages_access`
--
ALTER TABLE `pages_access`
  ADD PRIMARY KEY (`pages_id`),
  ADD KEY `templates_id` (`templates_id`);

--
-- Indexes for table `pages_parents`
--
ALTER TABLE `pages_parents`
  ADD PRIMARY KEY (`pages_id`,`parents_id`);

--
-- Indexes for table `pages_sortfields`
--
ALTER TABLE `pages_sortfields`
  ADD PRIMARY KEY (`pages_id`);

--
-- Indexes for table `process_forgot_password`
--
ALTER TABLE `process_forgot_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`),
  ADD KEY `ts` (`ts`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `session_login_throttle`
--
ALTER TABLE `session_login_throttle`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `fieldgroups_id` (`fieldgroups_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fieldgroups`
--
ALTER TABLE `fieldgroups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `forms_entries`
--
ALTER TABLE `forms_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1165;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
