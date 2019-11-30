export default {
    props: {
        draggable: {
            type: Boolean,
            default: function() {
                return false;
            }
        }
    },
    mounted() {
        if (this.draggable) {
            this.attachEventListeners();
        }
    },
    beforeDestroy() {
        if (this.draggable) {
            this.detachEventListeners();
        }
    },
    data() {
        return {
            focusPosition: {},
            selectedElement: null,
            selectedElementOffset: {},
            selectedElementTranslate: {},
            selectedElementOriginalTranslate: {},
            placeholders: [],
        }
    },
    methods: {
        attachEventListeners() {
            let svg = this.$el;

            svg.addEventListener('mousedown', this.startDrag.bind(this));
            svg.addEventListener('touchstart', this.startDrag.bind(this));

            svg.addEventListener('mousemove', this.drag.bind(this));
            svg.addEventListener('touchmove', this.drag.bind(this));

            svg.addEventListener('mouseup', this.endDrag.bind(this));
            svg.addEventListener('touchend', this.endDrag.bind(this));
            svg.addEventListener('touchcancel', this.endDrag.bind(this));

            svg.addEventListener('mouseleave', this.endDrag.bind(this));
            svg.addEventListener('touchleave', this.endDrag.bind(this));
        },
        detachEventListeners() {
            let svg = this.$el;

            svg.removeEventListener('mousedown', this.startDrag.bind(this));
            svg.removeEventListener('touchstart', this.startDrag.bind(this));

            svg.removeEventListener('mousemove', this.drag.bind(this));
            svg.removeEventListener('touchmove', this.drag.bind(this));

            svg.removeEventListener('mouseup', this.endDrag.bind(this));
            svg.removeEventListener('touchend', this.endDrag.bind(this));
            svg.removeEventListener('touchcancel', this.endDrag.bind(this));

            svg.removeEventListener('mouseleave', this.endDrag.bind(this));
            svg.removeEventListener('touchleave', this.endDrag.bind(this));
        },
        startDrag($event) {
            let target = $event.path.find(function(element) { return element.classList && element.classList.contains('draggable'); });
            if (target) {
                this.selectedElement = target;
                this.getFocusPosition($event);
                this.selectedElementOffset.x = this.focusPosition.x;
                this.selectedElementOffset.y = this.focusPosition.y;

                    // Get all the transforms currently on this element
                let transforms = this.selectedElement.transform.baseVal;

                // Ensure the first transform is a translate transform
                if (transforms.length === 0 ||
                    transforms.getItem(0).type !== SVGTransform.SVG_TRANSFORM_TRANSLATE) {

                    // Create an transform that translates by (0, 0)
                    let svg = this.$el;
                    let translate = svg.createSVGTransform();
                    translate.setTranslate(0, 0);

                    // Add the translation to the front of the transforms list
                    this.selectedElement.transform.baseVal.insertItemBefore(translate, 0);
                }

                // Get initial translation amount
                let translate = transforms.getItem(0);
                this.selectedElementOffset.x -= translate.matrix.e;
                this.selectedElementOffset.y -= translate.matrix.f;

                this.selectedElementTranslate = translate;
                this.selectedElementOriginalTranslate = {
                    x: translate.matrix.e,
                    y: translate.matrix.f,
                };

                this.showPlaceholders();
            }
        },
        drag($event) {
            if (this.selectedElement) {
                $event.preventDefault();
                this.getFocusPosition($event);
                this.selectedElementTranslate.setTranslate(this.focusPosition.x - this.selectedElementOffset.x, this.focusPosition.y - this.selectedElementOffset.y);
            }
        },
        endDrag($event) {
            if (this.selectedElement) {
                this.getFocusPosition($event);
                if (
                    this.placeholders[1] &&
                    this.focusPosition.x > this.placeholders[1].translateX &&
                    this.focusPosition.x < this.placeholders[1].translateX + this.symbolWidth &&
                    this.focusPosition.y > this.placeholders[1].translateY &&
                    this.focusPosition.y < this.placeholders[1].translateY + this.symbolHeight
                ) {
                    this.switchLayout();
                } else {
                    this.selectedElementTranslate.setTranslate(this.selectedElementOriginalTranslate.x, this.selectedElementOriginalTranslate.y);
                }

                this.selectedElement = null;
                this.hidePlaceholders();
            }
        },
        getFocusPosition($event) {
            let CTM = this.$el.getScreenCTM();
            if ($event.type.substring(0, 5) === 'touch') { // if touch event
                if ($event.touches && $event.touches[0]) { // validation check
                    this.focusPosition = {
                        x: ($event.touches[0].clientX - CTM.e) / CTM.a,
                        y: ($event.touches[0].clientY - CTM.f) / CTM.d
                    };
                }
            } else if ($event.type.substring(0, 5) === 'mouse') { // if mouse event
                this.focusPosition = {
                    x: ($event.clientX - CTM.e) / CTM.a,
                    y: ($event.clientY - CTM.f) / CTM.d
                };
            }
        },
        showPlaceholders() {
            let width = this.symbolWidth;

            if (this.layoutDirection === 'vertical') {
                let translateX = (this.width - width) / 2;
                let translateY = (this.height - this.boundingHeight) / 2;

                this.placeholders.push({
                    transform: 'translate(' + translateX + ', ' + translateY + ')',
                    translateX: translateX,
                    translateY: translateY,
                });

                if (this.companyNameIsPlaced) {
                    translateY += this.symbolHeight * (1 + this.symbolLineSpaceRate);
                    translateY += this.companyNameHeight * this.companyNameLineSpaceRate;

                    let height;
                    if (this.sloganIsPlaced) {
                        height = this.companyNameHeight * (1 + this.companyNameLineSpaceRate) + this.sloganHeight * (1 + this.sloganLineSpaceRate);
                    } else {
                        height = this.companyNameHeight;
                    }

                    translateY += (height - this.symbolHeight) / 2;
                    translateX -= this.symbolHeight * (1 + this.symbolLineSpaceRate);

                    this.placeholders.push({
                        transform: 'translate(' + translateX + ', ' + translateY + ')',
                        translateX: translateX,
                        translateY: translateY,
                    });
                } else if (this.sloganIsPlaced) {
                    translateY += this.symbolHeight * (1 + this.symbolLineSpaceRate);
                    translateY += this.sloganHeight * this.sloganLineSpaceRate;

                    let height = this.sloganHeight;

                    translateY += (height - this.symbolHeight) / 2;
                    translateX -= this.symbolHeight * (1 + this.symbolLineSpaceRate);

                    this.placeholders.push({
                        transform: 'translate(' + translateX + ', ' + translateY + ')',
                        translateX: translateX,
                        translateY: translateY,
                    });
                }
            } else {
                let translateX = (this.width - this.boundingWidth) / 2;
                let translateY = (this.height - this.boundingHeight) / 2;

                this.placeholders.push({
                    transform: 'translate(' + translateX + ', ' + translateY + ')',
                    translateX: translateX,
                    translateY: translateY,
                });

                if (this.textBoundingHeight) {
                    translateX = (this.width - this.symbolWidth) / 2;
                    translateY -= this.symbolHeight;

                    this.placeholders.push({
                        transform: 'translate(' + translateX + ', ' + translateY + ')',
                        translateX: translateX,
                        translateY: translateY,
                    });
                }
            }
        },
        hidePlaceholders() {
            this.placeholders = [];
        },
        switchLayout() {
            if (this.layoutDirection === 'vertical') {
                this.layoutDirection = 'horizontal';
            } else if (this.layoutDirection === 'horizontal') {
                this.layoutDirection = 'vertical';
            } else {
                console.log('Exception: (FE) unsupported layout direction', this.layoutDirection);
            }
        },
    }
}