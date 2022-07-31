<template>
    <v-app class="container">
        <v-btn @click="post">テスト送信</v-btn>
        <v-sheet height="600">
            <v-calendar
                ref="calendar"
                v-model="value"
                :weekdays="weekday"
                :type="type"
                :events="events"
                :event-overlap-mode="mode"
                :event-overlap-threshold="30"
                event-height="40"
                @change="getEvents"
            >
                <template v-slot:event="{ event }">
                    <!-- <div>あ</div> -->
                    <img
                        style="height: 40px; width: 100%; object-fit: cover"
                        src="data:image/jpeg;base64,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"
                    />
                </template>
            </v-calendar>
        </v-sheet>
        <select v-model="first">
            <option>か</option>
            <option>き</option>
            <option>く</option>
            <option>け</option>
            <option>こ</option>
            <option>あ</option>
        </select>
        <div v-for="text in filterTexts" :key="text.name">
            {{ text.name }}は{{ text.content }}
        </div>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            value: "",
            type: "month",
            mode: "stack",
            weekday: [0, 1, 2, 3, 4, 5, 6],
            weekdays: [
                { text: "Sun - Sat", value: [0, 1, 2, 3, 4, 5, 6] },
                { text: "Mon - Sun", value: [1, 2, 3, 4, 5, 6, 0] },
                { text: "Mon - Fri", value: [1, 2, 3, 4, 5] },
                { text: "Mon, Wed, Fri", value: [1, 3, 5] },
            ],
            events: [],
            colors: [
                "blue",
                "indigo",
                "deep-purple",
                "cyan",
                "green",
                "orange",
                "grey darken-1",
            ],
            names: [
                "Meeting",
                "Holiday",
                "PTO",
                "Travel",
                "Event",
                "Birthday",
                "Conference",
                "Party",
            ],
            users: [],
            // text: "かんぜんに理解した",
            first: "か",
            texts: [
                {
                    name: "ぼく",
                    content: "かんぜんに理解した",
                },
                {
                    name: "ぼく②",
                    content: "きんぜんに理解した",
                },
                {
                    name: "ぼく③",
                    content: "くんぜんに理解した",
                },
                {
                    name: "ぼく④",
                    content: "けんぜんに理解した",
                },
                {
                    name: "ぼく⑤",
                    content: "こんぜんに理解した",
                },
                {
                    name: "ぼく⑥",
                    content: "かかかかかかか",
                },
            ],
        };
    },
    computed: {
        filterTexts() {
            return this.texts.filter((text) => {
                const firstText = text.content.charAt(0);
                if (firstText === this.first) {
                    // console.log("理解してます");
                    return text;
                } else {
                    // console.log("理解してませんでした。残念でした。");
                }
            });
        },
    },
    created() {
        this.init();
    },
    methods: {
        post() {
            var formData = new FormData();
            formData.append("texts", JSON.stringify(this.texts));
            // formData.append("texts", this.texts);
            var config = {
                header: {
                    "Content-Type": "multipart/form-data",
                },
            };
            axios
                .post("api/post", formData, config)
                .then(({ data }) => {
                    console.log(data);
                })
                .catch((err) => {
                    console.log(err.response.data.errors);
                });
        },
        init() {
            axios.get("api/users").then(({ data }) => {
                this.users = data.users;
                // this.events = this.users;
                this.getEvents();
            });
        },
        getEvents() {
            const events = [];
            for (var i = 0; i < this.users.length; i++) {
                const first = new Date(this.users[i].created_at);
                events.push({
                    name: this.users[i].name,
                    start: first,
                });
            }
            this.events = events;

            // for (let i = 0; i < eventCount; i++) {
            //     const allDay = this.rnd(0, 3) === 0;
            //     const firstTimestamp = this.rnd(min.getTime(), max.getTime());
            //     const first = new Date(
            //         firstTimestamp - (firstTimestamp % 900000)
            //     );
            //     const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000;
            //     const second = new Date(first.getTime() + secondTimestamp);
            //     console.log(first);
            //     events.push({
            //         name: this.names[this.rnd(0, this.names.length - 1)],
            //         start: first,
            //         end: second,
            //         color: this.colors[this.rnd(0, this.colors.length - 1)],
            //         timed: !allDay,
            //     });
            // }
        },
        rnd(a, b) {
            return Math.floor((b - a + 1) * Math.random()) + a;
        },
    },
};
</script>
