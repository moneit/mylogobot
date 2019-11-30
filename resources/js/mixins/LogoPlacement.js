export default {
    props: {
        compact: {
            type: Boolean,
            default: function () {
                return false;
            }
        },
    },
    computed: {
        layoutDirection: {
            get() {
                let layoutComponents = this.layout.split('-');
                if (layoutComponents && layoutComponents[0]) {
                    return layoutComponents[0];
                }
                console.log('Exception: can not get direction from layout', this.layout);
                return '';
            },
            set(value) {
                let layoutComponents = this.layout.split('-');
                if (layoutComponents && layoutComponents[0]) {
                    layoutComponents[0] = value;
                    this.layout = layoutComponents.join('-');
                } else {
                    console.log('Exception: can not get direction from layout', this.layout);
                }
            }
        },
        boundingWidth() {
            let width = 0;

            if (this.layoutDirection === 'vertical') {
                if (this.symbolIsPlaced) {
                    width = this.symbolWidth;
                }
                if (this.companyNameIsPlaced) {
                    width = Math.max(this.companyNameWidth, width);
                }
                if (this.sloganIsPlaced) {
                    width = Math.max(this.sloganWidth, width);
                }
            } else if (this.layoutDirection === 'horizontal') {
                if (this.companyNameIsPlaced) {
                    width = Math.max(this.companyNameWidth, width);
                }
                if (this.sloganIsPlaced) {
                    width = Math.max(this.sloganWidth, width);
                }
                if (this.symbolIsPlaced) {
                    width += this.symbolWidth * (1 + this.symbolLineSpaceRate);
                }
            }

            return width;
        },
        textBoundingHeight() { // company name and slogan bounding height
            let height = 0;

            if (this.companyNameIsPlaced) {
                height += this.companyNameHeight * (1 + 2 * this.companyNameLineSpaceRate);
            }
            if (this.sloganIsPlaced) {
                height += this.sloganHeight * (1 + 2 * this.sloganLineSpaceRate);
            }

            //remove top margin
            if (this.companyNameIsPlaced) {
                height -= this.companyNameHeight * this.companyNameLineSpaceRate;
            } else if (this.sloganIsPlaced) {
                height -= this.sloganHeight * this.sloganLineSpaceRate;
            }

            //remove bottom margin
            if (this.sloganIsPlaced) {
                height -= this.sloganHeight * this.sloganLineSpaceRate;
            } else if (this.companyNameIsPlaced) {
                height -= this.companyNameHeight * this.companyNameLineSpaceRate;
            }

            return height;
        },
        boundingHeight() {
            let height = 0;

            if (this.layoutDirection === 'vertical') {
                if (this.symbolIsPlaced) {
                    height += this.symbolHeight * (1 + 2 * this.symbolLineSpaceRate);
                }
                if (this.companyNameIsPlaced) {
                    height += this.companyNameHeight * (1 + 2 * this.companyNameLineSpaceRate);
                }
                if (this.sloganIsPlaced) {
                    height += this.sloganHeight * (1 + 2 * this.sloganLineSpaceRate);
                }

                //remove top margin
                if (this.symbolIsPlaced) {
                    height -= this.symbolHeight * this.symbolLineSpaceRate;
                } else if (this.companyNameIsPlaced) {
                    height -= this.companyNameHeight * this.companyNameLineSpaceRate;
                } else if (this.sloganIsPlaced) {
                    height -= this.sloganHeight * this.sloganLineSpaceRate;
                }

                //remove bottom margin
                if (this.sloganIsPlaced) {
                    height -= this.sloganHeight * this.sloganLineSpaceRate;
                } else if (this.companyNameIsPlaced) {
                    height -= this.companyNameHeight * this.companyNameLineSpaceRate;
                } else if (this.symbolIsPlaced) {
                    height -= this.symbolHeight * this.symbolLineSpaceRate;
                }
            } else if (this.layoutDirection === 'horizontal') {
                height = this.textBoundingHeight;

                if (this.symbolIsPlaced) {
                    height = Math.max(this.symbolHeight, height);
                }
            }

            return height;
        },
        containerTransform() {
            let scale = this.containerScale;
            let width = this.containerWidth;
            let height = this.containerHeight;

            let translateX = (this.width - width) / 2;
            let translateY = (this.height - height) / 2;

            return 'translate(' + translateX + ', ' + translateY + ') scale(' + scale + ' ' + scale + ')';
        },
        symbolTransform() {
            let scale = this.symbolScale;
            let width = this.symbolWidth;

            if (this.layoutDirection === 'vertical') {
                let translateX = (this.width - width) / 2;
                let translateY = (this.height - this.boundingHeight) / 2;

                return 'translate(' + translateX + ', ' + translateY + ') scale(' + scale + ' ' + scale + ')';
            } else if (this.layoutDirection === 'horizontal') {
                let translateX = (this.width - this.boundingWidth) / 2;
                let translateY = (this.height - this.boundingHeight) / 2;

                if (this.symbolHeight < this.textBoundingHeight) {
                    translateY += (this.textBoundingHeight - this.symbolHeight) / 2;
                }

                return 'translate(' + translateX + ', ' + translateY + ') scale(' + scale + ' ' + scale + ')';
            }

            return 'scale(' + scale + ' ' + scale + ')';
        },
        companyNameTransform() {
            let scale = this.companyNameScale;
            let width = this.companyNameWidth;

            if (this.layoutDirection === 'vertical') {
                let translateX = (this.width - width) / 2;
                let translateY = (this.height - this.boundingHeight) / 2;

                if (this.symbolIsPlaced) {
                    translateY += this.symbolHeight * (1 + this.symbolLineSpaceRate);
                    translateY += this.companyNameHeight * this.companyNameLineSpaceRate;
                }

                return 'translate(' + translateX + ', ' + translateY + ') scale(' + scale + ' ' + scale + ')';
            } else if (this.layoutDirection === 'horizontal') {
                let translateX = (this.width - this.boundingWidth) / 2;
                let translateY = (this.height - this.boundingHeight) / 2;

                if (this.symbolIsPlaced) {
                    translateX += this.symbolWidth * (1 + this.symbolLineSpaceRate);
                    if (this.symbolHeight > this.textBoundingHeight) {
                        translateY += (this.symbolHeight - this.textBoundingHeight) / 2;
                    }
                }

                return 'translate(' + translateX + ', ' + translateY + ') scale(' + scale + ' ' + scale + ')';
            }

            return 'scale(' + scale + ' ' + scale + ')';
        },
        sloganTransform() {
            let scale = this.sloganScale;
            let width = this.sloganWidth;

            if (this.layoutDirection === 'vertical') {
                let translateX = (this.width - width) / 2;
                let translateY = (this.height - this.boundingHeight) / 2;

                if (this.symbolIsPlaced) {
                    translateY += this.symbolHeight * (1 + this.symbolLineSpaceRate);

                    if (this.companyNameIsPlaced) {
                        translateY += this.companyNameHeight * (1 + 2 * this.companyNameLineSpaceRate);
                    }

                    translateY += this.sloganHeight * this.sloganLineSpaceRate;
                } else if (this.companyNameIsPlaced) {
                    translateY += this.companyNameHeight * (1 + this.companyNameLineSpaceRate);
                    translateY += this.sloganHeight * this.sloganLineSpaceRate;
                }

                return 'translate(' + translateX + ', ' + translateY + ') scale(' + scale + ' ' + scale + ')';
            } else if (this.layoutDirection === 'horizontal') {
                let translateX = (this.width - this.boundingWidth) / 2;
                let translateY = (this.height - this.boundingHeight) / 2;

                if (this.symbolIsPlaced) {
                    translateX += this.symbolWidth * (1 + this.symbolLineSpaceRate);
                    if (this.symbolHeight > this.textBoundingHeight) {
                        translateY += (this.symbolHeight - this.textBoundingHeight) / 2;
                    }
                }
                if (this.companyNameIsPlaced) {
                    translateY += this.companyNameHeight * (1 + this.companyNameLineSpaceRate);
                    translateY += this.sloganHeight * this.sloganLineSpaceRate;
                }

                return 'translate(' + translateX + ', ' + translateY + ') scale(' + scale + ' ' + scale + ')';
            }

            return 'scale(' + scale + ' ' + scale + ')';
        },
        transform() {
            // return 'translate(' + this.width / 2 + ' ' + this.height / 2 + ') scale(' + this.scale + ' ' + this.scale + ') translate(' + -1 * this.width / 2 + ' ' + -1 * this.height / 2 + ')'; // todo: is it better to use 768 x 768 logo instead of 1024 x 768 logo ?, if so, refactor needs too much work?
            return 'translate(' + this.width / 2 + ' ' + this.height / 2 + ') scale(' + this.scale * 0.75+ ' ' + this.scale * 0.75+ ') translate(' + -1 * this.width / 2 + ' ' + -1 * this.height / 2 + ')';// scale whole logo with 0.75 so to fix long width logos
        }
    },
}