import { h } from 'vue'
import type { IconSet, IconAliases, IconProps } from 'vuetify'
import { ClIcons } from "../../../components/icons";

const aliases: IconAliases = {

}

const cli: IconSet = {
    component: (props: IconProps) => {
        let icon = props.icon;
        let type = 'linear';

        const regex = /:type:(.*)/;
        const match = props.icon.match(regex);
        if(match) {
            const regex = /:type:[^:]+/;
            type = match[1];
            icon = props.icon.replace(regex, '');
        }
        return h(ClIcons,{ icon: icon, type: props.type || type },`${props.icon}`)
    },
}

export { aliases, cli }
