const alerts = {
  modulesIndex: {
    type: 'info',
    html: `
<h3>Modules</h3>
<p>These are the existing <em>Modules</em>, on their respective <em>Pages</em>, in order of appearence.</p>
<ul>
<li>Modules that are not currently being used will be listed in the "orphan" tab</li>
<li>Drag and Drop to change order. Orphans can NOT be reordered</li>
<li>Click the right most icon to <em>Edit</em> the module</li>
</ul>`
  },

  moduleProperties: {
    type: 'warning',
    html: `
<h3>Properties</h3>
<p>For internal use. <strong>Do not change</strong>, unless it's absolutely necessary!</p>
<ul>
<li><strong>Module Name</strong> must be <em>unique</em>; can have letters and numbers only</li>
<li><strong>Page</strong> where this module belongs; Default is "home"</li>
<li><strong>Link To</strong> will insert a "learn more" button; Select "NONE" if you don't want the button</li>
</ul>`
  },

  moduleHeading: {
    type: 'info',
    html: `
<h3>Heading</h3>
<p>The heading ("gordas") for this module</p>
<ul>
<li>The heading is REQUIRED in all languages</li>
<li>Headings can have letters, numbers, spaces and symbols, but avoid using symbols</li>
<li>Headings are VERY important for SEO. Try to use shit you think people will search for</li>
</ul>`
  },

  moduleText: {
    type: 'info',
    html: `
<h3>Text</h3>
<p>The "body" of the module. The text will appear <em>under the module heading</em></p>
<ul>
<li>The text is REQUIRED in all languages</li>
<li>Text can be formatted in the editor</li>
</ul>`
  },

  moduleStyle: {
    type: 'info',
    html: `
<h3>Style</h3>
<p>The styling for this module</p>
<ul>
<li>You can select an image to associate with the module</li>
<li>You can choose where the image will be placed: either inside the module as background, or alongside</li>
<li>You can edit currently assigned css styles</li>
<li>To add more styles, click the "Add" button below</li>
<li>To remove applied styles, click the trash icon by the style you wish to remove</li>
</ul>`
  },

  modulePreview: {
    type: 'info',
    html: `
<h3>Preview</h3>
<p>Here you can see how the module looks, before saving any changes. Remember to check out all languages.</p>`
  },

  pageProperties: {
    type: 'warning',
    html: `
<h3>Properties</h3>
<p>This is for internal use. <strong>Do not change</strong>, unless it's absolutely necessary!</p>
<ul>
<li><strong>Page Name</strong> can have letters and numbers only</li>
<li><strong>Route Name</strong> can have letters and dots only. Make sure the route exists</li>
</ul>`
  },

  pageHeadings: {
    type: 'info',
    html: `
<h3>Heading</h3>
<p>The heading will appear <em>in the top of the page body, right under the logo</em>.</p>
<ul>
<li>The heading can be empty.</li>
<li>If the heading is empty, it MUST be empty in ALL languages</li>
<li>If a heading is set in some language, it MUST be set in ALL languages</li>
<li>Headings can have letters, numbers, spaces and symbols</li>
</ul>`
  },

  pageBody: {
    type: 'info',
    html: `
<h3>Page Text</h3>
<p>The text will appear <em>under the page heading</em>.</p>
<ul>
<li>The text can be empty.</li>
<li>If the text is empty, it MUST be empty in ALL languages</li>
<li>If a text is set in some language, it MUST be set in ALL languages</li>
<li>Text can be formatted in the editor</li>
</ul>`
  },

  pageSeo: {
    type: 'info',
    html: `
<h3>Search Engine Optimization</h3>
<p>This elements will provide meta-data for search engine crawlers, such as google, bing, etc.</p>
<p>Robots meta-tag provides directives to whether search engines bots should index this page.</p>
<ul>
<li>The title is <strong>REQUIRED</strong> in all languages</li>
<li>Titles and descriptions are generated automatically, based on contents</li>
<li>Only change if you are not happy with page analytics</li>
<li>Title and Description SHOULD be set in ALL languages</li>
<li>Can have letters, numbers, punctuation and spaces. Avoid using symbols!</li>
<li>Recommended Max size for title: 60 characters</li>
<li>Recommended Max size for description: 150 - 160 characters</li>
<li>Description can be empty, if robots="noindex"</li>
<li>Robots should only index relevant content. Never allow to index pages such as "Contact Form" "Login", "Register", etc</li>
</ul>`
  },

  pageModules: {
    type: 'info',
    html: `
<h3>Modules</h3>
<p>Modules for this page, in order.</p>
<ul>
<li>Drag and Drop to change order</li>
<li>Click "Edit" icon to edit the module</li>
<li>Click "Create" icon to create a new module</li>
</ul>`
  }
}

export default alerts
