<mj-section padding="{{$padding}}" css-class="{{$cssClass}}">
    <mj-column padding="0">
        <mj-text align="{{$align}}" line-height="{{ceil($fontSize*1.4)}}px" font-size="{{$fontSize}}px" font-weight="{{$fontWeight}}" font-family="{{$fontFamily}}">
            {{$slot}}
        </mj-text>
    </mj-column>
</mj-section>
