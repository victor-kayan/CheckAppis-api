const { override, fixBabelImports, addLessLoader } = require('customize-cra');

module.exports = override(
    fixBabelImports('antd', {
        libraryName: 'antd',
        libraryDirectory: 'es',
        style: true
    }),
    fixBabelImports('antpro', {
        libraryName: 'ant-design-pro',
        libraryDirectory: 'lib',
        style: true,
        camel2DashComponentName: false
    }),
    addLessLoader({
        javascriptEnabled: true,
        modifyVars: {
            /**
             |--------------------------------------------------------------------------
             | COLORS
             |--------------------------------------------------------------------------
            */
            '@primary-color': '#0086FC',
            // // '@info-color': '#51bcda',
            // // '@success-color': '#6bd098',
            // // '@processing-color': '@blue-6',
            // // '@error-color': 'rgb(185, 74, 72)',
            // // '@highlight-color': '@red-6',
            // // '@warning-color': '#fbc658',
            // // '@normal-color': '#66615B',
            // // '@white': '#fff',
            // // '@black': '#000',

            // // Background color for `<body>`
            '@body-background': '#f0f2f5', //#f6f8f9
            // // // Base background color for most components
            // // @component-background: #fff,
            // // @font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC', 'Hiragino Sans GB',
            // //   'Microsoft YaHei', 'Helvetica Neue', Helvetica, Arial, sans-serif, 'Apple Color Emoji',
            // //   'Segoe UI Emoji', 'Segoe UI Symbol',
            // // @code-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier, monospace,
            '@text-color': '#8c8c8c',
            // // @text-color-secondary: fade(@black, 45%),
            // // @text-color-inverse: @white,
            // // @icon-color: inherit,
            // // @icon-color-hover: fade(@black, 75%),
            // @heading-color: fade(#000, 85%),
            // // @heading-color-dark: fade(@white, 100%),
            // // @text-color-dark: fade(@white, 85%),
            // // @text-color-secondary-dark: fade(@white, 65%),
            // // @text-selection-bg: @primary-color,
            // // @font-variant-base: tabular-nums,
            // // @font-feature-settings-base: 'tnum',
            '@font-size-base': '16px',
            '@font-size-lg': '@font-size-base + 2px',
            '@font-size-sm': '14px',
            // // @heading-1-size: ceil(@font-size-base * 2.71),
            // // @heading-2-size: ceil(@font-size-base * 2.14),
            // // @heading-3-size: ceil(@font-size-base * 1.71),
            // // @heading-4-size: ceil(@font-size-base * 1.42),
            // '@line-height-base': '1.5',
            '@border-radius-base': '2px',
            '@border-radius-sm': '0px',


            /**
             |--------------------------------------------------------------------------
             | LAYOUT
             |--------------------------------------------------------------------------
            */
            // // vertical paddings
            // '@padding-lg': '24px', // containers
            // '@padding-md': '16px', // small containers and buttons
            // '@padding-sm': '12px', // Form controls and items
            // '@padding-xs': '8px', // small items


            /**
             |--------------------------------------------------------------------------
             | LAYOUT
             |--------------------------------------------------------------------------
            */
            '@layout-body-background': '@body-background',
            // '@layout-header-background': '#fff',
            // @layout-footer-background: @layout-body-background;
            // @layout-header-height: 64px;
            // @layout-header-padding: 0 50px;
            // @layout-footer-padding: 24px 50px;
            // '@layout-sider-background': '#151b26',
            // @layout-trigger-height: 48px;
            // @layout-trigger-background: #002140;
            // @layout-trigger-color: #fff;
            // @layout-zero-trigger-width: 36px;
            // @layout-zero-trigger-height: 42px;
            // // Layout light theme
            // @layout-sider-background-light: #fff;
            // @layout-trigger-background-light: #fff;
            // @layout-trigger-color-light: @text-color;


            /**
             |--------------------------------------------------------------------------
             | FORM
             |--------------------------------------------------------------------------
            */
            // @label-required-color: @highlight-color;
            '@label-color': '@text-color',
            // @form-warning-input-bg: @input-bg;
            '@form-item-margin-bottom': '32px',
            // @form-item-trailing-colon: true;
            // @form-vertical-label-padding: 0 0 8px;
            // @form-vertical-label-margin: 0;
            // @form-error-input-bg: @input-bg;


            /**
             |--------------------------------------------------------------------------
             | INPUT
             |--------------------------------------------------------------------------
            */
            '@input-height-base': '40px',
            '@input-height-lg': '48px',
            '@input-height-sm': '28px',
            '@input-padding-horizontal': '@control-padding-horizontal + 6px',
            '@input-padding-horizontal-base': '@input-padding-horizontal',
            '@input-padding-horizontal-sm': '@control-padding-horizontal-sm - 1px',
            '@input-padding-horizontal-lg': '@input-padding-horizontal',
            // '@input-padding-vertical-base': '4px',
            // '@input-padding-vertical-sm': '1px',
            // '@input-padding-vertical-lg': '6px',
            // '@input-placeholder-color': '@text-color',
            // '@input-color': '@text-color',
            // '@input-border-color': 'hsv(0, 0, 0.8941)',
            // // @input-bg: @component-background,
            // // @input-number-handler-active-bg: #f4f4f4,
            '@input-addon-bg': '#ffffff',
            // // @input-hover-border-color: @primary-color,
            // // @input-disabled-bg: @disabled-bg,
            // // @input-outline-offset: 0 0,


            /**
             |--------------------------------------------------------------------------
             | BUTTONS
             |--------------------------------------------------------------------------
            */
            // '@btn-font-weight': '500',
            // // @btn-border-radius-base: @border-radius-base,
            // @btn-border-radius-sm: @border-radius-base,
            // '@btn-border-width': '0px',
            // // @btn-border-style: @border-style-base,
            // '@btn-shadow': '0px 15px 30px rgba(0, 134, 252, 0.4)',
            // '@btn-primary-shadow': '0px 15px 30px rgba(0, 134, 252, 0.4)',
            // // @btn-text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.12),

            // // @btn-primary-color: #fff,
            // // @btn-primary-bg: @primary-color,

            // // @btn-default-color: @text-color,
            // // @btn-default-bg: @component-background,
            '@btn-default-border': 'transparent',

            // // @btn-danger-color: @error-color,
            // // @btn-danger-bg: @background-color-base,
            // // @btn-danger-border: @border-color-base,

            // // @btn-disable-color: @disabled-color,
            // // @btn-disable-bg: @disabled-bg,
            // // @btn-disable-border: @border-color-base,

            // @btn-padding-base: 0 @padding-md - 1px,
            // '@btn-font-size-lg': '@font-size-lg - 2px',
            // '@btn-font-size-sm': '@font-size-base - 2px',
            // @btn-padding-lg: @btn-padding-base,
            // @btn-padding-sm: 0 @padding-xs - 1px,

            '@btn-height-base': '40px',
            '@btn-height-lg': '48px',
            '@btn-height-sm': '28px',

            '@btn-circle-size': '@btn-height-base - 6px',
            '@btn-circle-size-lg': '@btn-height-lg - 6px',
            '@btn-circle-size-sm': '@btn-height-sm - 6px',


            /**
             |--------------------------------------------------------------------------
             | MENU
             |--------------------------------------------------------------------------
            */
            // @menu-inline-toplevel-item-height: 40px;
            // @menu-item-height: 40px;
            // @menu-collapsed-width: 80px;
            // @menu-bg: @component-background;
            // @menu-popup-bg: @component-background;
            // '@menu-item-color': '@text-color',
            // @menu-highlight-color: @primary-color;
            // @menu-item-active-bg: @item-active-bg;
            // @menu-item-active-border-width: 3px;
            // @menu-item-group-title-color: @text-color-secondary;

            // // dark theme
            // '@menu-dark-color': '#646f79',
            // '@menu-dark-bg': '@layout-sider-background',
            // @menu-dark-arrow-color: #fff;
            // '@menu-dark-submenu-bg': '@layout-sider-background',
            // @menu-dark-highlight-color: #fff;
            // @menu-dark-item-active-bg: @primary-color;


            /**
             |--------------------------------------------------------------------------
             | TREE
             |--------------------------------------------------------------------------
            */
            // // ---
            // @tree-title-height: 24px;
            // @tree-child-padding: 18px;
            // '@tree-directory-selected-color': '#fff',
            // @tree-directory-selected-bg: @primary-color;


            /**
             |--------------------------------------------------------------------------
             | MODAL
             |--------------------------------------------------------------------------
            */
            //'@modal-body-padding': '24px',
            '@modal-header-bg': '@primary-color',
            // //'@modal-footer-bg': 'transparent',
            // //'@modal-mask-bg': 'fade('@black', '65%')',


            /**
             |--------------------------------------------------------------------------
             | GRID SYSTEM
             |--------------------------------------------------------------------------
            */
            '@grid-columns': '12'
        }
    })
);
