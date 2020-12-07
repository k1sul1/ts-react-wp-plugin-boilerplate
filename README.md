# Empty plugin boilerplate for WordPress using TypeScript, React and Webpack

Designed to be modular, and to have everything you need without anything extra. React and TypeScript are optional, but you wouldn't need a boilerplate if you weren't using at least one of them.

## Usage

Assuming you're looking at the actual barebones repo and not at a finished plugin where someone didn't write you a readme, here's how to get started.

First, do search-replaces. Case-sensitive.

- myEmptyPlugin -> yourEmptyPlugin
- NS -> yourNameSpace
- myemptyplugin -> yourtextdomain

Then, just install the dependencies and start working.

`npm install`

Dev: `npm run start`
Build for prod: `npm run build`

This barebones config was stripped from https://github.com/libreform/libreform. This is mainly for my use, but if it's of use to someone else, great. **Before you go changing things, there's probably a reason why they are the way they are.**

## Removing TS and React

To remove React, just remove it from your script dependencies when you enquque them. It's not included in your build to begin with.

To "remove" TypeScript, simply create .js equivalents of admin.ts and frontend.ts, and update webpack config paths to match. I encourage you to try TS though. You can always use `any` as type if you're stuck and need to get shit done.

## Travis?

Should work out of the box.
