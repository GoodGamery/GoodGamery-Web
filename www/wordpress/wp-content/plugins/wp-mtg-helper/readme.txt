=== Plugin Name ===
Contributors: backseatsurfer
Donate link: https://www.paypal.com/cgi-bin/webscr?country_code=DE&cmd=_s-xclick&hosted_button_id=635826
Tags: magic, mtg, magic the gathering, help, deck, card, draft, link
Requires at least: 2.5
Tested up to: 1.1.1
Stable tag: 1.1.1

Mtg Helper supports you writing "Magic:the Gathering"-articles

== Description ==

The goal of this plugin is to help you writing articels about Magic: the Gathering like tournament reports or draft walkthroughs and reducing the time you need for posting decks and link cards to their picture.
All this stuff is taken care of by the plugin and that's not the enf of it. MtG-Helper does not only link cards for you it also creates good looking deck lists, sealed pools and booster drafts.
The only thing you have to do is typ in the cards.
If you still not convinced, take a look at the screenshots.

If your have any questions how to use the plugin take a look into the FAQ (or readme-file). If this doesn't help, [contact me](http://www.backseatsurfer.de/feedback/). Maybe I could help

= Upgrading from older version to 1.0+ =

*To save yourself trouble deactivate the plugin and remove it from your wordpress instalation before upgrading to a newer version!* 

== Installation ==

1. Upload the full directory into your wp-content/plugins directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enjoy

== Frequently Asked Questions ==

=How does the cardlist and custom tags work?=
It&#39;s like using BBCode. Just put the tag around the card names. To seperate cards from each other you can use three different posibilities:
- simple linke breaks (one row for each card)
- semicolon
- &#42;&#60;quantity&#62;  &#60;cardname&#62;

=How do I link single cards?=
Just wrap [card][/card] around the card name.

=Why doe's the backside of the magic card appear instead of a card picture?=
Most of the time the card wasnt spelled correct. Make sure you dont use inverted comma in the card name. Just ignore it.

=How do I combine cards into a category?=
To combine cards into a category you have to put them inside another /"tag/", which lies inside your used tag (E.g. [cardlist]). Besides special character you can name your category like you want. Just be sure you do not forget to close the tag.
A sample category could look like these: &#91White&#93;&#60;cardnames&#62;&#91White&#93;

=Additional Attributes in the editor:=
What you can&#39;t set on this page are the title of your cardlists and the picked card for draft walkthroughs. If you want a title for your deck you have to declare it while writing your post by putting another argument inside the tag. E. g. [cardlist title=&#60;your title&#62;] (without the &#60;&#62;!). The pick is declared similar but instead of the argument "title" you have to use the argument /"pick/". E. g. [cardlist pick=&#60;cardname&#62;].
Certainly the cardname must be a card inside your list otherwise there will be no card highlited.
Sometimes even the custom tag may not fit your need. If you only need some attributes once you don't have to create a new custom tag. Just use the argument /"style/" inside the tag like you can set your title and pick.
As a matter of course all three arguments can be used simultaneously.

=About the layouts:=
There are three different layout you can choose: cardbox, tooltip and thumbnail. These layout affect how the cards are linked. When you choose cardbox as layout the cards will be displayed in text list. The card images will appear in a box right next to the list. Tooltip is similar but instead of a box a tooltip will appear when you mouseover a card inside the text list.
The thumbnail layout differs from the other styles. The cards will placed as smaller a version side by side. When you mousover them the choosen action will enlarge them (or not if your choosen action is none).

=About Categories:=
A category combines several cards visually. There are two different layouts for the categories.
The first is headline. By choosing this possibility the given category name ist put before each set of cards, which belong to the category. The second possibility is tabbed, which means that tabs are generate and placed at the top of the cardlist.

=What does the button option do?=
When you enable these option for the cardlist or a custom tag a button in the Wordpress editor is created so you don&#39;t have to always write the tag down.

=What does the pick setting do?=
These attribute is first of all inteded for draft walkthroughs. When you enable this attribute and you declare a pick (means card name, see /"Additional Attributes in the editor/" for further information) the selected card is highlited. You also can choose toggle so your readers can manually show or hide the picked card.


== Screenshots ==

1. Deck view with decktitle and dynamic linke break
2. Single Card linked with WP MtG-Helper
3. Draft view with titles and highlighted pick
