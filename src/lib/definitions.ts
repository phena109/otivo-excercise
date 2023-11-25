export interface AccommodationProps {
    image?: string
    name: string
}

export interface AccommodationListProps {
    list: AccommodationProps[]
}

export interface Area {
    name: string
}

export interface City {
    area: string;
    city: string;
}
