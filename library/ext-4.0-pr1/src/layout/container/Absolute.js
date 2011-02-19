/**
 * @class Ext.layout.container.Absolute
 * @extends Ext.layout.container.Anchor
 * <p>This is a layout that inherits the anchoring of <b>{@link Ext.layout.container.Anchor}</b> and adds the
 * ability for x/y positioning using the standard x and y component config options.</p>
 * <p>This class is intended to be extended or created via the <tt><b>{@link Ext.container.Container#layout layout}</b></tt>
 * configuration property.  See <tt><b>{@link Ext.container.Container#layout}</b></tt> for additional details.</p>
 * <p>Example usage:</p>
 * <pre><code>
var form = new Ext.form.FormPanel({
    title: 'Absolute Layout',
    layout:'absolute',
    layoutConfig: {
        // layout-specific configs go here
        itemCls: 'x-abs-layout-item',
    },
    baseCls: 'x-plain',
    url:'save-form.php',
    defaultType: 'textfield',
    items: [{
        x: 0,
        y: 5,
        xtype:'label',
        text: 'Send To:'
    },{
        x: 60,
        y: 0,
        name: 'to',
        anchor:'100%'  // anchor width by percentage
    },{
        x: 0,
        y: 35,
        xtype:'label',
        text: 'Subject:'
    },{
        x: 60,
        y: 30,
        name: 'subject',
        anchor: '100%'  // anchor width by percentage
    },{
        x:0,
        y: 60,
        xtype: 'textareafield',
        name: 'msg',
        anchor: '100% 100%'  // anchor width and height
    }]
});
</code></pre>
 */

Ext.define('Ext.layout.container.Absolute', {

    /* Begin Definitions */

    alias: 'layout.absolute',

    extend: 'Ext.layout.container.Anchor',

    requires: ['Ext.chart.axis.Axis', 'Ext.fx.Anim'],

    /* End Definitions */

    itemCls: Ext.baseCSSPrefix + 'abs-layout-item',

    type: 'absolute',

    onLayout: function() {
        target = this.getTarget();
        target.position();
        this.paddingLeft = target.getPadding('l');
        this.paddingTop = target.getPadding('t');
        Ext.layout.container.Absolute.superclass.onLayout.apply(this, arguments);
    },

    // private
    adjustWidthAnchor: function(value, comp) {
        //return value ? value - comp.getPosition(true)[0] + this.paddingLeft: value;
        return value ? value - comp.getPosition(true)[0] : value;
    },

    // private
    adjustHeightAnchor: function(value, comp) {
        //return value ? value - comp.getPosition(true)[1] + this.paddingTop: value;
        return value ? value - comp.getPosition(true)[1] : value;
    }
});