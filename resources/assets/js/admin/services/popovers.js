export const pageName = {
  label: 'Page Name',
  body: `
<p>Internal name for the page.</p>
<ul>
<li>Must be Unique</li>
<li>Only letters and numbers</li>
<li>Avoid editing</li>
</ul>`
}

export const routeName = {
  label: 'Route Name',
  body: `
<p>The route name associated to the page.</p>
<ul>
<li>Only letters and dots</li>
<li>Make sure route is declared in /routes/web.php</li>
</ul>`
}

export const pageHeading = {
  label: 'Page Heading',
  body: `
<p>The heading will appear <em>in the top of the page body, right under the logo</em>.</p>
<ul>
<li>The heading can be empty</li>
<li>If the heading is empty, it MUST be empty in ALL languages</li>
<li>If a heading is set in some language, it MUST be set in ALL languages</li>
<li>Headings can have letters, numbers, spaces and symbols. Avoid symbols</li>
</ul>`
}

export const pageBody = {
  label: 'Page Body',
  body: `
<p>The body will appear under the page <em>Heading</em>.</p>
<ul>
<li>The body can be empty</li>
<li>If the body is empty, it MUST be empty in ALL languages</li>
<li>If a body is set in some language, it MUST be set in ALL languages</li>
<li>The body can be formatted in the editor</li>
</ul>`
}

export const pageTitle = {
  label: 'Page Title',
  body: `
<p>Search Engine optimization (SEO).</p>
<ul>
<li>The title is <strong>REQUIRED</strong> in all languages</li>
<li>Can have letters, numbers, symbols and spaces. Avoid symbols</li>
<li>Recommended Max size: 60 characters</li>
</ul>`
}

export const pageDescription = {
  label: 'Page Description',
  body: `
<p>Search Engine Optimization (SEO).</p>
<ul>
<li>The description is <strong>REQUIRED</strong> in all languages, if <strong>Robots</strong>='index'</li>
<li>Can have letters, numbers, symbols and spaces. Avoid symbols</li>
<li>Recommended Max size: 150 characters</li>
<li>Description can be empty, if robots="noindex"</li>
</ul>`
}

export const pageRobots = {
  label: 'Robots',
  body: `
<p>Search Engine Optimization (SEO).</p>
<p>Robots meta-tag provides directives to whether search engines bots should index this page.</p>
<ul>
<li>Robots should only index relevant content. Never allow to index pages such as "Contact Form" "Login", "Register", etc</li>
</ul>`
}

export const pageModules = {
  label: 'Page Modules',
  body: `
<p>Modules for this page, in order.</p>
<ul>
<li>Drag and Drop to change order</li>
<li>Click "Edit" icon to edit the module</li>
</ul>`
}

export const modulesIndex = {
  label: 'Modules',
  body: `
<p>These are the existing <em>Modules</em>, on their respective <em>Pages</em>, in order of appearence.</p>
<ul>
<li>Modules that are not currently associated to any Page will be listed in the "orphan" tab</li>
<li>Drag and Drop to change order. Orphans can NOT be reordered</li>
<li>Click the right most icon to <em>Edit</em> the module</li>
</ul>`
}

export const moduleName = {
  label: 'Module Name',
  body: `
<p>Internal name for the module.</p>
<ul>
<li>Must be Unique</li>
<li>Only letters and numbers</li>
<li>Once created, avoid changes</li>
</ul>`
}

export const modulePage = {
  label: 'Page',
  body: `
<p>The <strong>Page</strong> where this module belongs.</p>
<ul>
<li>Default is "home"</li>
<li>Select from list</li>
</ul>`
}

export const moduleMore = {
  label: 'Link To',
  body: `
<p>Inserts a "Learn more" button.</p>
<ul>
<li>Select linked page from list</li>
<li>Do not select anything if you don't want a "learn more" button</li>
</ul>`
}

export const moduleHeading = {
  label: 'Module Heading',
  body: `
<p>The heading ("gordas") for this module.</p>
<ul>
<li>The heading is <strong>REQUIRED</strong> in all languages</li>
<li>Headings can have letters, numbers, spaces and symbols. Avoid using symbols</li>
<li>Headings are VERY important for SEO. Try to use shit you think people will search for</li>
</ul>`
}

export const moduleText = {
  label: 'Module Body',
  body: `
<p>The "body" of the module. The text will appear under the module <em>Heading</em></p>
<ul>
<li>The Body is <strong>REQUIRED</strong> in all languages</li>
<li>Text can be formatted in the editor</li>
</ul>`
}

export const moduleImage = {
  label: 'Module Image',
  body: `
<p>You can select a background image to associate with the module, if you wish.</p>
<p>You can also choose where to append the image:</p>
<ul>
<li>Inside the module as background</li>
<li>Outside the module, as a side image</li>
</ul>`
}

export const moduleCssClass = {
  label: 'Custom CSS Class',
  body: `
<p>The Styling for this module.</p>
<ul>
<li>You can specify a pre-defined CSS <em>class</em> for this module; Default is "app-module"</li>
<li>Class can have letters, dashes, underscores and/or spaces for multiple classes</li>
<li>NO symbols, for classes</li>
<li>First character of a CSS class <strong>must always be a letter</strong></li>
<li>You can also apply particular CSS rules, by clicking the "Add CSS Rule" button below</li>
<li>To edit applied rules, click the pencil icon (blue) in the "Actions" column</li>
<li>To remove applied rules, click the trash icon (red) in the "Actions" column</li>
</ul>
`
}

export const modulePreview = {
  label: 'CSS styles',
  body: '<p>Here you can see how the module looks, before saving any changes. Remember to check out all languages.</p>'
}
